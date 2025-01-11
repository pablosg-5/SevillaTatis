<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles\profile.css">
</head>

<body>
  <header>
    <h1>Hola, profile</h1>
    <h1>Sevillatatis</h1>
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
    <img src="../img/icon.jpg" alt="imagen de perfil" class="perfil">
    <section>
      <header>
        <h2>My Bookings</h2>
      </header>

      <article>
        <figure>
          <img src="../img/betis.jpg" alt="Betis Tour">
          <figcaption>Betis Tour</figcaption>
        </figure>
        <p>€16.95 per person</p>
        <p>1 u</p>
        <input type="button" value="CANCEL" onclick="window.location.href='profile.php';">
      </article>

      <article>
        <figure>
          <img src="../img/cerveza.jpg" alt="Beer Tasting">
          <figcaption>Beer Tasting by Bars</figcaption>
        </figure>
        <p>€34.95 per person</p>
        <p>2 u</p>
        <input type="button" value="CANCEL" onclick="window.location.href='profile.php';">
      </article>

      <article>
        <figure>
          <img src="../img/plaza_espana.jpg" alt="City Tour">
          <figcaption>Tour for the Center</figcaption>
        </figure>
        <p>€9.95 per person</p>
        <p>2 u</p>
        <input type="button" value="CANCEL" onclick="window.location.href='profile.php';">
      </article>
    </section>
  </main>
  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>