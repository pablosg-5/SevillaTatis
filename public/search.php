<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UT">
  <meta name="viewport" content="width=devicidth, initiacale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles\search.css">
</head>

<body>
  <header>
    <h1>Hola, search</h1>
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
    <section>
      <header>
        <h2>Experience</h2>
      </header>

      <form method="post" action="search.php">
        <label for="searcar">Buscar</label>
        <input id="searcar" type="text" placeholder="Buscar...">
        <input type="hidden" name="filtro" value="">
        <input type="image" src="../img/lupa.jpg" alt="Enviar">
        <input type="submit" value="Precio" onclick="document.getElementById('filtro').value='precio';">
        <input type="submit" value="A-Z" onclick="document.getElementById('filtro').value='az';">
        <input type="submit" value="Vista de lista" onclick="document.getElementById('filtro').value='lista';">
      </form>

      <article>
        <form action="buy.php" method="post">
          <figure>
            <input type="image" src="../img/campo_betis.jpg" alt="Betis Tour" name="image_name">
            <figcaption>Betis Tour</figcaption>
            <p>€16.95 per person</p>
            <input type="hidden" name="image_path" value="../img/campo_betis.jpg">
          </figure>
        </form>
      </article>

      <article>
        <form action="buy.php" method="post">
          <figure>
            <input type="image" src="../img/cerveza.jpg" alt="Beer Tasting" name="image_name">
            <figcaption>Beer Tasting by Bars</figcaption>
            <p>€34.95 per person</p>
            <input type="hidden" name="image_path" value="../img/cerveza.jpg">
          </figure>
        </form>
      </article>

      <article>
        <form action="buy.php" method="post">
          <figure>
            <input type="image" src="../img/alcazar.jpg" alt="Alcazar tour" name="image_name">
            <figcaption>Alcazar Tour</figcaption>
            <p>€14.95 per person</p>
            <input type="hidden" name="image_path" value="../img/alcazar.jpg">
          </figure>
        </form>
      </article>

      <article>
        <form action="buy.php" method="post">
          <figure>
            <input type="image" src="../img/caballo.jpg" alt="Horse Tour" name="image_name">
            <figcaption>Horse Tour</figcaption>
            <p>€11.95 per person</p>
            <input type="hidden" name="image_path" value="../img/caballo.jpg">
          </figure>
        </form>
      </article>

      <article>
        <form action="buy.php" method="post">
          <figure>
            <input type="image" src="../img/plaza_espana.jpg" alt="Tour for the center" name="image_name">
            <figcaption>Tour for the center</figcaption>
            <p>€9.95 per person</p>
            <input type="hidden" name="image_path" value="../img/plaza_espana.jpg">
          </figure>
        </form>
      </article>

      <article>
        <form action="buy.php" method="post">
          <figure>
            <input type="image" src="../img/triana.jpg" alt="Triana Tour" name="image_name">
            <figcaption>Triana Tour</figcaption>
            <p>€19.95 per person</p>
            <input type="hidden" name="image_path" value="../img/triana.jpg">
          </figure>
        </form>
      </article>
    </section>
  </main>
  <footer>
    <p>Universidad Pablo de OlavideAlma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>