<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['id_experience']) || !isset($_SESSION['num_tickets']) || !isset($_SESSION['fecha'])) {
    header('Location: search.php');
    exit();
}

// Sanitize and validate session variables.
$id_experience = filter_var($_SESSION['id_experience'], FILTER_VALIDATE_INT);
$num_tickets = filter_var($_SESSION['num_tickets'], FILTER_VALIDATE_INT);
$fecha = filter_var($_SESSION['fecha'], FILTER_SANITIZE_STRING);
$user_id = filter_var($_SESSION['usuario'], FILTER_VALIDATE_INT);

// If any validation fails, redirect to search page.
if (!$id_experience || !$num_tickets || !$fecha || !$user_id) {
    header('Location: search.php');
    exit();
}

$con = conexionDB();

// Prepare query to prevent SQL injection.
$sql = "INSERT INTO reservas (id_cliente, id_anuncio, cantidad, fecha) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'iiis', $user_id, $id_experience, $num_tickets, $fecha);
    if (mysqli_stmt_execute($stmt)) {
        $mensaje = "Purchase successfully completed. Redirecting...";
    } else {
        $mensaje = "Error processing the purchase. Please try again.";
    }
    mysqli_stmt_close($stmt);
} else {
    $mensaje = "Internal error. Please try again later.";
}

// Clean up session variables related to the purchase.
unset($_SESSION['id_experience']);
unset($_SESSION['num_tickets']);
unset($_SESSION['fecha']);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Simulation</title>
    <link rel="stylesheet" href="styles/pago.css">
</head>

<body>
    <h1>Processing your payment...</h1>
    <progress value="0" max="100" id="progressBar" aria-label="Progress of the payment process"></progress>
    <p><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>

    <script>
        // Simulate progress with an animated progress bar.
        let progressBar = document.getElementById("progressBar");
        let progress = 0;
        let interval = setInterval(() => {
            progress += 5;
            progressBar.value = progress;
            if (progress >= 100) {
                clearInterval(interval);
                window.location.href = "profile.php"; // Redirect to the profile page once the progress is complete
            }
        }, 150);
    </script>
</body>

</html>