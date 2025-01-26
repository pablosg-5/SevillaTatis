<?php
// Incluir el archivo de funciones
include 'functions.php';

session_start();

// Si existe una sesión activa, redirigir a log_out.php
if (isset($_SESSION['usuario'])) {
  header("Location: log_out.php");
  exit();
}

// Si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Consultar a la base de datos para verificar las credenciales
  $conn = conexionDB();
  $sql = "SELECT * FROM clientes WHERE nombre_usuario='$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1) {
  if ($username === 'admin') {
    $sql = "SELECT * FROM administradores WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['contrasena'])) {
      // Crear sesión
      $_SESSION['usuario'] = $row['id'];
      header("Location: profile.php");
      exit();
    if (mysqli_num_rows($result) === 1) {
      // Compare the entered password with the hashed password in the database
      if (password_verify($password, $row['contrasena'])) {
        $_SESSION['admin'] = 'admin';
        header("Location: admin_page.php");
        exit();
      } else {
        $error_password = "Incorrect password.";
      }
    } else {
      $error_password = "Contraseña incorrecta.";
    }
  } else {
    $error_username = "Usuario no encontrado.";
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
  <link rel="stylesheet" href="styles\login.css">


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
    <img src="../img/icon.jpg" alt="icon">
    <h2>Iniciar sesión</h2>
    <form action="login.php" method="POST">
      <input type="hidden" name="login" value="1">
      <?php
      if (isset($error_username)) {
        echo "<p style='color: red;'>$error_username</p>";
      } ?>
      <?php
      if (isset($error_password)) {
        echo "<p style='color: red;'>$error_password</p>";
      } ?>
      <label for="username">Nombre de usuario:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Iniciar sesión</button>
      <br>
    </form>
    <a href="new_account.php">Create new Account</a>
  </main>
</body>
<footer>
  <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
  <p>By Pablo S&aacute;nchez G&oacute;mez</p>
</footer>

</html>