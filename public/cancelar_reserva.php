<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$con = conexionDB();
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id_exp = isset($_POST['exp']) ? $_POST['exp'] : null;
$accion = isset($_POST['boton']) ? $_POST['boton'] : null;

$mensaje = '';

// Depuración: Mostrar valores recibidos
error_log("ID Exp: " . $id_exp);
error_log("Accion: " . $accion);

if ($accion === 'cancelar') {
    if ($id_exp) {
        $sql = "DELETE FROM `reservas` WHERE id_anuncio='$id_exp'";
        if (mysqli_query($con, $sql)) {
            $mensaje = "Reserva cancelada con éxito. Redirigiendo...";
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
} else {
    $mensaje = "Acción no válida.";
    // Depuración: Mostrar mensaje de error
    error_log("Mensaje: " . $mensaje);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelar o Modificar Reserva</title>
</head>
<body>
    <p><?= $mensaje ?></p>
    <script>
        setTimeout(function() {
            window.location.href = "profile.php";
        }, 3000);
    </script>
    <?php if ($accion === 'modificar' && isset($reserva) && empty($mensaje)): ?>
        <h1>Modificar Reserva</h1>
        <form action="" method="POST">
            <input type="hidden" name="exp" value="<?= $id_exp ?>">
            <input type="hidden" name="id_reserva" value="<?= $reserva['id_anuncio'] ?>">
            <input type="hidden" name="boton" value="modificar">
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

            <button type="submit" name="boton" value="modificar">Guardar cambios</button>
            <a href="profile.php"><button type="button">Cancelar</button></a>
        </form>
    <?php else: ?>
        <h1><?= $mensaje ? 'Resultado' : 'Error' ?></h1>
        <p><?= $mensaje ?></p>
        <a href="profile.php">Volver al perfil</a>
    <?php endif; ?>
</body>
</html>