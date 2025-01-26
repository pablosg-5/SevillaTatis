<?php
include 'functions.php';
session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Sanitize inputs to prevent SQL injection
$id_exp = filter_input(INPUT_POST, 'exp', FILTER_SANITIZE_NUMBER_INT);
$accion = filter_input(INPUT_POST, 'accion', FILTER_SANITIZE_STRING);

$con = conexionDB();

$mensaje = "";

// If action is 'cancelar', delete the reservation
if ($accion === 'cancelar') {
    if ($id_exp) {
        // Prepare and execute DELETE query
        $stmt = $con->prepare("DELETE FROM `reservas` WHERE id_anuncio=?");
        $stmt->bind_param("i", $id_exp);
        if ($stmt->execute()) {
            $mensaje = "Reservation successfully canceled.";
            // Insert the notification into the database
            $stmt2 = $con->prepare("INSERT INTO `notifications` (user_id, message) VALUES (?, ?)");
            $stmt2->bind_param("is", $_SESSION['usuario'], $mensaje);
            $stmt2->execute();
            $stmt2->close();
        } else {
            $mensaje = "Error canceling reservation: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensaje = "Error: Advertisement ID not provided.";
    }
} elseif ($accion === 'modificar') {
    // If action is 'modificar', check if form is submitted to update reservation
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_reserva'])) {
        $nueva_fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
        $nueva_cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
        $id_reserva = isset($_POST['id_reserva']) ? $_POST['id_reserva'] : null;

        if ($nueva_fecha && $nueva_cantidad && $id_reserva) {
            // Prepare and execute UPDATE query
            $stmt = $con->prepare("UPDATE `reservas` SET fecha=?, cantidad=? WHERE id_anuncio=?");
            $stmt->bind_param("sii", $nueva_fecha, $nueva_cantidad, $id_reserva);
            if ($stmt->execute()) {
                $mensaje = "Reservation successfully modified.";
                // Insert the notification into the database
                $stmt2 = $con->prepare("INSERT INTO `notifications` (user_id, message) VALUES (?, ?)");
                $stmt2->bind_param("is", $_SESSION['usuario'], $mensaje);
                $stmt2->execute();
                $stmt2->close();
            } else {
                $mensaje = "Error modifying reservation: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "Error: Incomplete data to modify the reservation.";
        }
    } else {
        if ($id_exp) {
            $stmt = $con->prepare("SELECT * FROM `reservas` WHERE id_anuncio=?");
            $stmt->bind_param("i", $id_exp);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $reserva = $resultado->fetch_assoc();

            if (!$reserva) {
                $mensaje = "Error: Reservation not found.";
            }
            $stmt->close();
        } else {
            $mensaje = "Error: Advertisement ID not provided.";
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel or Modify Reservation</title>
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/modify.css">
</head>

<body>
    <header>
        <h1>Sevillatatis</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="search.php">Search experiences</a></li>
                <li><a href="about.php">Who we are</a></li>
                <li><a href="more.php">More</a></li>
            </ul>
            <a class="boton" href="login.php"><?= htmlspecialchars($login_text) ?></a>
        </nav>
    </header>

    <section id="notification" class="notification"><?= htmlspecialchars($mensaje) ?></section>

    <main>
        <?php if ($accion === 'modificar' && isset($reserva) && empty($mensaje)): ?>
            <h2>Modify Reservation</h2>
            <form action="" method="POST">
                <input type="hidden" name="exp" value="<?= htmlspecialchars($id_exp) ?>">
                <input type="hidden" name="id_reserva" value="<?= htmlspecialchars($reserva['id_anuncio']) ?>">
                <input type="hidden" name="accion" value="modificar">
                <input type="hidden" name="modificar_reserva" value="1">

                <label for="fecha">Select a new date:</label>
                <input type="date" name="fecha" value="<?= htmlspecialchars($reserva['fecha']) ?>" required>
                <br><br>

                <label for="cantidad">Number of tickets:</label>
                <select name="cantidad">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        $selected = ($i == $reserva['cantidad']) ? 'selected' : '';
                        echo "<option value='$i' $selected>$i ticket" . ($i > 1 ? 's' : '') . "</option>";
                    }
                    ?>
                </select>
                <br><br>
                <section>
                    <button type="submit">Save changes</button>
                    <a href="profile.php"><button type="button">Cancel</button></a>
                </section>
            </form>
        <?php else: ?>
            <script>
                // Show alert with the notification message
                document.addEventListener('DOMContentLoaded', function() {
                    const mensaje = "<?= htmlspecialchars($mensaje) ?>";
                    if (mensaje !== "") {
                        alert(mensaje); // Show alert
                    }

                    // Redirect after a short delay
                    setTimeout(function() {
                        window.location.href = "profile.php";
                    }, 3000);
                });
            </script>
            <h1><?= htmlspecialchars($mensaje) ?></h1>
            <a href="profile.php">Back to profile</a>
        <?php endif; ?>
    </main>

    <footer>
        <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
        <p>By Pablo Sánchez Gómez</p>
    </footer>
</body>

</html>