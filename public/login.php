<?php
include 'functions.php';

session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';

if (isset($_SESSION['usuario'])) {
  header("Location: log_out.php");
  exit();
}

// If the form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get and sanitize the username and password from the form
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $password = $_POST['password'];

  $conn = conexionDB();

  // Check if the user is admin
  if ($username === 'admin') {
    $sql = "SELECT * FROM administradores WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
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
      $error_username = "Username not found.";
    }
  } else {
    // Search for the user in the clients table
    $sql = "SELECT * FROM clientes WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) === 1) {
      // Compare the entered password with the hashed password in the database
      if (password_verify($password, $row['contrasena'])) {
        // Create session for the user
        $_SESSION['usuario'] = $row['id'];
        header("Location: profile.php");
        exit();
      } else {
        $error_password = "Incorrect password.";
      }
    } else {
      $error_username = "Username not found.";
    }
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles/general.css">
  <link rel="stylesheet" href="styles/login.css">
</head>

<body>
  <header>
    <h1>Sevillatatis</h1>
    <nav>
      <ul>
        <li><a href="profile.php" aria-label="Go to profile page">Profile</a></li>
        <li><a href="search.php" aria-label="Search for experiences">Search experiences</a></li>
        <li><a href="about.php" aria-label="Learn about who we are">Who we are</a></li>
        <li><a href="more.php" aria-label="Learn more">More</a></li>
      </ul>
      <a class="boton" href="login.php" aria-label="<?= htmlspecialchars($login_text) ?>"><?= $login_text ?></a>
    </nav>
  </header>

  <main>
    <img src="../img/icon.jpg" alt="Login icon" class="wow-effect">
    <h2>Log In</h2>
    <form action="login.php" method="POST">
      <input type="hidden" name="login" value="1">

      <!-- Display error messages if username or password is incorrect -->
      <?php if (isset($error_username)): ?>
        <p style="color: red;" aria-live="assertive"><?= htmlspecialchars($error_username) ?></p>
      <?php endif; ?>

      <?php if (isset($error_password)): ?>
        <p style="color: red;" aria-live="assertive"><?= htmlspecialchars($error_password) ?></p>
      <?php endif; ?>

      <label for="username" aria-label="Username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="password" aria-label="Password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" aria-label="Submit login form">Log In</button>
      <br>
    </form>
    <a href="new_account.php" aria-label="Create a new account">Create new Account</a>
  </main>
</body>

<footer>
  <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
  <p>By Pablo Sánchez Gómez</p>
</footer>

</html>