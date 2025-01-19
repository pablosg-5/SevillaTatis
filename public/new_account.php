<?php
// Incluir el archivo de funciones
include 'functions.php';

session_start();

// Si existe una sesión activa, redirigir a log_out.php
if (isset($_SESSION['usuario'])) {
    header("Location: log_out.php");
    exit();
}

// Inicializar mensajes de error
$error_username = $error_password = null;

// Si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que las claves existen en $_POST
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;

    if ($password !== $confirm_password) {
        echo "<script>alert('Las contraseñas no coinciden.');</script>";
    } else {
        // Encriptar la contraseña (por ejemplo, usando bcrypt)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el usuario en la base de datos

        $name=$_POST['name'];
        $birthdate=$_POST['birthdate'];
        $surname=$_POST['surname'];
        $conn = conexionDB();
        $sql = "INSERT INTO clientes (nombre, apellido, fecha_nacimiento, nombre_usuario, contrasena) 
                    VALUES ('$name', '$surname', '$birthdate', '$username', '$hashedPassword')";
        if ($conn->query($sql) === TRUE) {
            // Crear una sesión
            session_start();
            $_SESSION['usuario'] = $username;

            // Redirigir al perfil
            header("Location: profile.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sevillatatis</title>
    <link rel="stylesheet" href="styles/new_account.css">
</head>

<body>
<main>
        <form action="new_account.php" method="POST" enctype="multipart/form-data">
            <h2 class="section">Create New Account</h2>

            <?php
            if ($error_username) {
                echo "<p style='color: red;'>$error_username</p>";
            }
            if ($error_password) {
                echo "<p style='color: red;'>$error_password</p>";
            }
            ?>

            <p>Name:</p>
            <input type="text" name="name" required>

            <p>Surname:</p>
            <input type="text" name="surname" required>

            <p>Date of Birth:</p>
            <input type="date" name="birthdate" required>

            <p>Profile Picture:</p>
            <input type="file" name="profile_picture" accept="image/*" required>

            <p>Username:</p>
            <input type="text" name="username" required>

            <p>Password:</p>
            <input type="password" name="password" required>

            <p>Confirm Password:</p>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Create Account">
        </form>
    </main>
</body>

</html>