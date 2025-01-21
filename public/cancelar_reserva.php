<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$con = conexionDB();
$id_exp = $_POST['exp'];
$accion = $_POST['boton'];

$mensaje = '';

if ($accion === 'cancelar') {
    $sql = "DELETE FROM `reservas` WHERE id_anuncio='$id_exp'";
    if (mysqli_query($con, $sql)) {
        $mensaje = "Reserva cancelada con éxito. Redirigiendo...";
    } else {
        $mensaje = "Error al cancelar la reserva: " . mysqli_error($con);
    }
} elseif ($accion === 'modificar') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_reserva'])) {
        $nueva_fecha = $_POST['fecha'];
        $nueva_cantidad = $_POST['cantidad'];
        $id_reserva = $_POST['id_reserva'];

        $sql = "UPDATE `reservas` SET fecha='$nueva_fecha', cantidad='$nueva_cantidad' WHERE id_anuncio='$id_reserva'";
        if (mysqli_query($con, $sql)) {
            $mensaje = "Reserva modificada con éxito. Redirigiendo...";
            
        } else {
            $mensaje = "Error al modificar la reserva: " . mysqli_error($con);
        }
    } else {
        $sql = "SELECT * FROM `reservas` WHERE id_anuncio='$id_exp'";
        $resultado = mysqli_query($con, $sql);
        $reserva = mysqli_fetch_assoc($resultado);

        if (!$reserva) {
            $mensaje = "Error: No se encontró la reserva.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reserva</title>
    <link rel="stylesheet" href="styles/pago.css">
    <link rel="stylesheet" href="styles\general.css">

</head>

<body>
    <?php if ($accion === 'cancelar'): ?>
        <h1>Cancelando reserva...</h1>
        <p><?= $mensaje ?></p>
        <script>
            setTimeout(function() {
                window.location.href = "profile.php";
            }, 3000);
        </script>
    <?php elseif ($accion === 'modificar' && isset($reserva) && empty($mensaje)): ?>
        <h1>Modificar Reserva</h1>
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
                    $selected = ($i == 1) ? 'selected' : ''; // Seleccionamos la opción 1 por defecto
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