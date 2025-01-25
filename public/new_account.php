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

    if ($_POST['opcion'] == 'cancel') {
        header('location: login.php');
        exit();
    }
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

        $name = $_POST['name'];
        $birthdate = $_POST['birthdate'];
        $surname = $_POST['surname'];
        $conn = conexionDB();
        $sql = "INSERT INTO clientes (nombre, apellido, fecha_nacimiento, nombre_usuario, contrasena) 
                    VALUES ('$name', '$surname', '$birthdate', '$username', '$hashedPassword')";
        if ($conn->query($sql) === TRUE) {
            // Crear una sesión
            session_start();
            $sql="SELECT id FROM clientes where nombre_usuario = ('$username')";
            $id_usuario=mysqli_fetch_assoc(mysqli_query($conn,$sql))['id'];
            $_SESSION['usuario'] = $id_usuario;

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

    <link rel="stylesheet" href="styles\general.css">
    <link rel="stylesheet" href="styles\new_account.css">

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
            <a id="boton" href="login.php">Log in/Log out</a>
        </nav>
    </header>
    <main>
        <h2 class="section">Create New Account</h2>
        <form action="new_account.php" method="POST" enctype="multipart/form-data">


            <?php
            if ($error_username) {
                echo "<p style='color: red;'>$error_username</p>";
            }
            if ($error_password) {
                echo "<p style='color: red;'>$error_password</p>";
            }
            ?>

            <section>
                <p>Name:</p>
                <input type="text" name="name">
            </section>
            <section>
                <p>Surname:</p>
                <input type="text" name="surname">
            </section>
            <section>
                <p>Date of Birth:</p>
                <input type="date" name="birthdate">
            </section>
            <section>
                <p>Username:</p>
                <input type="text" name="username">
            </section>
            <section>
                <p>Password:</p>
                <input type="password" name="password">
            </section>
            <section>
                <p>Confirm Password:</p>
                <input type="password" name="confirm_password">
            </section>
            <section id="boton">
            <button type="submit" value="Create Account">Create Account</button>
            <button type="submit" name="opcion" value="cancel">Cancel</button>
        </section>
        </form>
    </main>
</body>
<footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
</footer>

</html>