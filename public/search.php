<?php
include 'functions.php';
session_start();

$con = conexionDB();

$sql = "SELECT * FROM experiencias";
$result = mysqli_query($con, $sql);


?>

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

      <?php
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <article>
          <form action="buy.php" method="$_POST">
            <figure>
              <?php
              echo '<input type="image" src="' . $row['imagen'] . '"alt="' . $row['nombre'] . '"name="' . $row['nombre'] . '">';
              echo '<figcaption>' . $row['nombre'] . '</figcaption>';
              echo '<p>€' . $row['precio'] . ' per person</p>';
              echo '<input type="hidden" name="id_experience" value="' . $row['id'] . '">';
              ?>
            </figure>
          </form>
        </article>
      <?php
      }
      ?>

    </section>
  </main>
  <footer>
    <p>Universidad Pablo de OlavideAlma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>