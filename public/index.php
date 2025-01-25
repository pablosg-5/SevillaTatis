<!DOCTYPE html>
<html lang="es">

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
        <li><a href="profile.php">Profile</a></li>
        <li><a href="search.php">Search experiences</a></li>
        <li><a href="about.php">Who we are</a></li>
        <li><a href="more.php">More</a></li>
      </ul>
      <a id="boton" href="login.php">Log in/Log out</a>
    </nav>
  </header>
  <main>
    <article>
    <img src="../img\portada.jpg" class="elementos" alt="A bridge in Plaza España, Sevilla" class="principal">
    <p class="elementos">Sevilla is the capital of Andalucia, the southernmost region of Spain. It is a city full of art, culture, and experiences.</p>
    </article>
    <input type="button" class="boton" value="Booking experiences" onclick="window.location.href='search.php';">
  </main>
  <footer>
    <p id="texto-izquierda">Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p id="texto-derecha">By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>