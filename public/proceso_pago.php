<?php
include 'functions.php';
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
if (!isset($_SESSION['id_experience']) || !isset($_SESSION['num_tickets'])) {
    header('Location: search.php');
    exit();
}

$id_experience = $_SESSION['id_experience'];
$num_tickets = $_SESSION['num_tickets'];

$con = conexionDB();
$user_id = $_SESSION['usuario'];
$sql = "INSERT INTO reservas (id_cliente, id_anuncio, cantidad) VALUES ('$user_id', '$id_experience', '$num_tickets')";
if (mysqli_query($con, $sql)) {
    $mensaje = "Compra realizada con éxito. Redirigiendo...";
} else {
    $mensaje = "Error al procesar la compra: " . mysqli_error($con);
}

unset($_SESSION['id_experience']);
unset($_SESSION['num_tickets']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-style=1.0">
    <title>Simulación de Pago</title>
    <link rel="stylesheet" href="styles/pago.css">
</head>

<body>
    <h1>Procesando Pago...</h1>
    <script>
        setTimeout(function() {
            window.location.href = "profile.php";
        }, 3000);
    </script>
</body>

</html>