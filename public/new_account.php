<?php

// Incluir el archivo de funciones
require('functions.php');

// Verificar si se ha enviado el formulario
if (isset($_POST)) {
    // Obtener los datos del formulario
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthdate = $_POST['birthdate'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validar los datos (por ejemplo, verificar que las contraseñas coincidan)
    if ($password !== $confirmPassword) {
        echo "<script>alert('Las contraseñas no coinciden.');</script>";
    } else {
        // Encriptar la contraseña (por ejemplo, usando bcrypt)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el usuario en la base de datos
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
            <img src="../img/icon.jpg" alt="Profile">
            <h2 class="section">Create New Account</h2>

            <p>Name:</p>
            <input type="text" name="name" required>

            <p>Surname:</p>
            <input type="text" name="surname" required>

            <p>Date of Birth:</p>
            <input type="date" name="birthdate" required>

            <p>Profile Picture:</p>
            <input type="file" name="profile_picture" accept="image/*">

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