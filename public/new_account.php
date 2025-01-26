<?php
include 'functions.php';

session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';

if (isset($_SESSION['usuario'])) {
    header("Location: log_out.php");
    exit();
}

$error_username = $error_password = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['opcion'] == 'cancel') {
        header('location: login.php');
        exit();
    }

    // Validate that required fields exist in $_POST
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;

    if ($password !== $confirm_password) {
        echo "<script>alert('The passwords do not match.');</script>";
    } else {
        // Validate that the password is secure (at least 8 characters, one uppercase letter, one lowercase letter, and one number)
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[A-Z]).{8,}$/', $password)) {
            echo "<script>alert('The password must be at least 8 characters long, include one uppercase letter, one lowercase letter, and one number.');</script>"; // Password security message
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user into the database securely using prepared statements
            $name = $_POST['name'];
            $birthdate = $_POST['birthdate'];
            $surname = $_POST['surname'];
            $conn = conexionDB();

            // Use a prepared statement to avoid SQL injection
            $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellido, fecha_nacimiento, nombre_usuario, contrasena) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $surname, $birthdate, $username, $hashedPassword);

            if ($stmt->execute()) {
                session_start();
                $stmt = $conn->prepare("SELECT id FROM clientes WHERE nombre_usuario = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $id_usuario = $result->fetch_assoc()['id'];
                $_SESSION['usuario'] = $id_usuario;

                header("Location: profile.php");
                exit();
            } else {
                echo "<script>alert('There was an error creating the account. Please try again later.');</script>";
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sevillatatis</title>
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/new_account.css">
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
            <a class="boton" href="login.php" aria-label="Login or Logout"><?= htmlspecialchars($login_text) ?></a>
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
                <input type="text" name="name" required aria-label="Enter your name">
            </section>
            <section>
                <p>Surname:</p>
                <input type="text" name="surname" required aria-label="Enter your surname">
            </section>
            <section>
                <p>Date of Birth:</p>
                <input type="date" name="birthdate" required aria-label="Select your date of birth">
            </section>
            <section>
                <p>Username:</p>
                <input type="text" name="username" required aria-label="Enter your username">
            </section>
            <section>
                <p>Password:</p>
                <input type="password" name="password" required aria-label="Enter your password">
            </section>
            <section>
                <p>Confirm Password:</p>
                <input type="password" name="confirm_password" required aria-label="Confirm your password">
            </section>
            <section id="boton">
                <button type="submit" name="opcion" aria-label="Submit your account creation">Create Account</button>
                <button type="submit" name="opcion" value="cancel" aria-label="Cancel account creation">Cancel</button>
            </section>
        </form>
    </main>
</body>
<footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo Sánchez Gómez</p>
</footer>

</html>