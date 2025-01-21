<?php
include 'functions.php';;
session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}
$conn = conexionDB();
// Obtener datos del usuario
$id = $_SESSION['usuario'];
$sql = "SELECT * FROM clientes WHERE id='$id'";
$resultP = mysqli_query($conn, $sql);
$rowP = mysqli_fetch_assoc($resultP);

// Obtener las reservas del usuario
$sql = "SELECT * FROM reservas WHERE id_cliente='$id'";
$resultR = mysqli_query($conn, $sql);
?>

<head>
  <meta charset="UT">
  <meta name="viewport" content="width=devicidth, initiacale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles\general.css">
  <link rel="stylesheet" href="styles\profile.css">

</head>

<body>
  <header>
    <h1>Sevillatatis</h1>
    <nav>
      <ul>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="search.php">Search experiences</a></li>
        <li><a href="about.php">Who we are</a></li>
        <li><a href="more.php">More about Sevilla</a></li>
      </ul>
      <a id="boton" href="login.php">Log in/Log out</a>
    </nav>
  </header>

  <main>
    <h2>Mis Reservas</h2>
    <section>
      <?php
      if (mysqli_num_rows($resultR) > 1) {
        while ($reserva = mysqli_fetch_assoc($resultR)) {

          $id = $reserva['id_anuncio'];
          $sql = "SELECT * FROM `experiencias` WHERE id='$id'";
          $experiencia = mysqli_fetch_assoc(mysqli_query($conn, $sql));
          $nombreExpe = $experiencia['nombre'];
          $precioExpe = $experiencia['precio'];
          $cantidad = $reserva['cantidad'];

      ?>
          <article>
            <figure>
              <img src="<?= $experiencia['imagen'] ?>" alt="<?= $nombreExpe ?>">
              <figcaption><?= $nombreExpe ?></figcaption>
            </figure>
            <p>€<?= $precioExpe ?> per person</p>
            <p><?= $cantidad ?> u</p>
            <form action="cancelar_reserva.php" method="post">
              <input type="hidden" id="exp" name="exp" value="<?= $id ?>">
              <input type="hidden" id="boton" name="boton" value="">
              <input type="submit" value="Cancelar" onclick="document.getElementById('boton').value='cancelar'"></input>
              <input type="submit" value="Modificar" onclick="document.getElementById('boton').value='modificar'"></input>
            </form>
          </article>

        <?php
        }
        ?>
      <?php
      } else if (mysqli_num_rows($resultR) == 1) {
        $reserva = mysqli_fetch_assoc($resultR);
        $id = $reserva['id_anuncio'];
        $sql = "SELECT * FROM `experiencias` WHERE id='$id'";
        $experiencia = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $nombreExpe = $experiencia['nombre'];
        $precioExpe = $experiencia['precio'];
        $cantidad = $reserva['cantidad'];
      ?>

        <article>
          <figure>
            <img src="<?= $experiencia['imagen'] ?>" alt="<?= $nombreExpe ?>">
            <figcaption><?= $nombreExpe ?></figcaption>
          </figure>
          <p>€<?= $precioExpe ?> por persona</p>
          <p><?= $cantidad ?> u</p>
          <form action="cancelar_reserva.php" method="post">
            <input type="hidden" id="exp" name="exp" value="<?= $id ?>">
            <input type="hidden" id="boton" name="boton" value="">
            <input type="submit" value="Cancelar" onclick="document.getElementById('boton').value='cancelar'"></input>
            <input type="submit" value="Modificar" onclick="document.getElementById('boton').value='modificar'"></input>
          </form>
        </article>

      <?php
      } else {
        echo '<p>No tienes reservas aún.</p>';
      }
      ?>
    </section>
  </main>

  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>