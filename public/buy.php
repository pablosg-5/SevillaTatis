<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles\buy.css">
</head>

<body>
  <header>
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

    <figure>
      <img src="../img/campo_betis.jpg" alt="Betis Tour">
      <figcaption>Betis Tour</figcaption>
    </figure>
    <form action="buy.php" method="$_POST">
      <p>This experience will take you through the facilities of Real Betis Balompié, allowing you to discover more about its history, achievements, and the daily life of the players. You will have the chance to visit part of the pitch where players and the coaching staff are during matches. Additionally, you will see the club's locker rooms and press room. During this visit, you will feel like a true member of the club and receive exclusive gifts upon leaving.</p>
      <p>16.95€</p>
      <select name="num_tickets" id="num_tickets">
        <?php
        // Generamos las opciones de la lista desplegable
        for ($i = 1; $i <= 5; $i++) {
          $selected = ($i == 1) ? 'selected' : ''; // Seleccionamos la opción 1 por defecto
          echo "<option value='$i' $selected>$i ticket" . ($i > 1 ? 's' : '') . "</option>";
        }
        ?>
      </select>
      <input type="submit" value="BUY">
      <input type="submit" value="CANCEL">
    </form>
  </main>

  <footer>
    <p>Universidad Pablo de OlavideAlma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>