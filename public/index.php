<?php
session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles\general.css">
  <link rel="stylesheet" href="styles\home.css">
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
    <article>
      <img src="../img/portada.jpg" class="elementos" alt="A scenic view of Plaza España bridge in Sevilla, surrounded by water and architectural details." class="principal">
      <p class="elementos">Sevilla is the capital of Andalucia, the southernmost region of Spain. It is a city full of art, culture, and experiences.</p>
    </article>

    <input type="button" class="boton" value="Booking experiences" onclick="window.location.href='search.php';" aria-label="Book experiences">
  </main>

  <footer>
    <p class="texto-izquierda">Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p class="texto-derecha">By Pablo Snchez Gómez</p>
  </footer>
</body>

</html>