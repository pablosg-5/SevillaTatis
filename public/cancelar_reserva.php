<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$id_exp = ($_POST['exp']);
$accion = ($_POST['accion']);


$con = conexionDB();
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}
$mensaje = "";
if ($accion === 'cancelar') {
    if ($id_exp) {
        $sql = "DELETE FROM `reservas` WHERE id_anuncio='$id_exp'";
        if (mysqli_query($con, $sql)) {
            $mensaje = "Reserva cancelada con éxito. Redirigiendo...";
        if ($stmt->execute()) {
            $mensaje = "Reservation successfully canceled.";
            // Insert the notification into the database
            $stmt2 = $con->prepare("INSERT INTO `notifications` (user_id, message) VALUES (?, ?)");
            $stmt2->bind_param("is", $_SESSION['usuario'], $mensaje);
            $stmt2->execute();
            $stmt2->close();
        } else {
            $mensaje = "Error al cancelar la reserva: " . mysqli_error($con);
        }
    } else {
        $mensaje = "Error: ID de anuncio no proporcionado.";
    }
} elseif ($accion === 'modificar') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_reserva'])) {
        $nueva_fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
        $nueva_cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
        $id_reserva = isset($_POST['id_reserva']) ? $_POST['id_reserva'] : null;

        if ($nueva_fecha && $nueva_cantidad && $id_reserva) {
            $sql = "UPDATE `reservas` SET fecha='$nueva_fecha', cantidad='$nueva_cantidad' WHERE id_anuncio='$id_reserva'";
            if (mysqli_query($con, $sql)) {
                $mensaje = "Reserva modificada con éxito. Redirigiendo...";
            if ($stmt->execute()) {
                $mensaje = "Reservation successfully modified.";
                // Insert the notification into the database
                $stmt2 = $con->prepare("INSERT INTO `notifications` (user_id, message) VALUES (?, ?)");
                $stmt2->bind_param("is", $_SESSION['usuario'], $mensaje);
                $stmt2->execute();
                $stmt2->close();
            } else {
                $mensaje = "Error al modificar la reserva: " . mysqli_error($con);
            }
        } else {
            $mensaje = "Error: Datos incompletos para modificar la reserva.";
        }
    } else {
        if ($id_exp) {
            $sql = "SELECT * FROM `reservas` WHERE id_anuncio='$id_exp'";
            $resultado = mysqli_query($con, $sql);
            $reserva = mysqli_fetch_assoc($resultado);

            if (!$reserva) {
                $mensaje = "Error: No se encontró la reserva.";
            }
        } else {
            $mensaje = "Error: ID de anuncio no proporcionado.";
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar o Modificar Reserva</title>
    <link rel="stylesheet" href="styles\general.css">
    <link rel="stylesheet" href="styles\modify.css">
</head>

<body>
    <header>
        <h1>Sevillatatis</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="search.php">Search experiences</a></li>
                <li><a href="about.php">Who we are</a></li>
                <li><a href="more.php">More about Sevilla</a></li>
            </ul>
            <a id="boton" href="login.php">Log in/Log out</a>
        </nav>
    </header>
    <main>
        <p><?= $mensaje ?></p>
        <?php if ($accion === 'modificar' && isset($reserva) && empty($mensaje)): ?>
            <h2>Modificar Reserva</h2>
            <form action="" method="POST">
                <input type="hidden" name="exp" value="<?= $id_exp ?>">
                <input type="hidden" name="id_reserva" value="<?= $reserva['id_anuncio'] ?>">
                <input type="hidden" name="accion" value="modificar">
                <input type="hidden" name="modificar_reserva" value="1">

                <label for="fecha">Selecciona una nueva fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?= $reserva['fecha'] ?>" required>
                <br><br>

                <label for="cantidad">Cantidad de tickets:</label>
                <select name="cantidad" id="cantidad">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        $selected = ($i == $reserva['cantidad']) ? 'selected' : ''; // Seleccionamos la opción actual por defecto
                        echo "<option value='$i' $selected>$i ticket" . ($i > 1 ? 's' : '') . "</option>";
                    }
                    ?>
                </select>
                <br><br>
                <section class="boton-container">
                    <button type="submit" name="boton" value="modificar" id="boton">Guardar cambios</button>
                    <a href="profile.php"><button type="button" id="boton">Cancelar</button></a>
                </section>
            </form>
        <?php else: ?>
            <script>
                setTimeout(function() {
                    window.location.href = "profile.php";
                }, 3000);
                // Show alert with the notification message
                document.addEventListener('DOMContentLoaded', function() {
                    const mensaje = "<?= htmlspecialchars($mensaje) ?>";
                    if (mensaje !== "") {
                        alert(mensaje); // Show alert
                    }
            </script>
            <h1><?= $mensaje ? 'Resultado' : 'Error' ?></h1>
            <a href="profile.php">Volver al perfil</a>
        <?php endif; ?>
    </main>

    <footer>
        <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
        <p>By Pablo S&aacute;nchez G&oacute;mez</p>
    </footer>
</body>

</html>