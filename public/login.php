<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles\login.css">
</head>

<body>
  <header>
    <h1>Hola, login</h1>
    <nav>
      <ul>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="search.php">Search experiences</a></li>
        <li><a href="about.php">Who we are</a></li>
        <li><a href="more.php">More about Sevilla</a></li>
      </ul>
      <a href="login.php">Log in/Log out</a>
    </nav>
  </header>
  <main>
    <form action="profile.php" method="$_POST">
      <img src="../img/icon.jpg" alt="Profile">
      <h2 class="section">Login</h2>
      <p>Name: </p>
      <input type="text" value="">
      <p>Password: </p>
      <input type="text" value="">
      <input type="submit" value="Login">
    </form>

    <a href="new_account.php">create new account</a>

  </main>
  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>