<?php

include 'functions.php';;
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

// Conexión a la base de datos (reemplazar con tus credenciales)

$conn = conexionDB();

// Obtener datos del usuario
$usuario = $_SESSION['usuario'];
$sql = "SELECT * FROM clientes WHERE nombre_usuario='$usuario'";
$resultP = mysqli_query($conn, $sql);
$rowP=mysqli_fetch_assoc($resultP);
$id_cliente = $rowP['id'];

// Obtener las reservas del usuario
$sql = "SELECT * FROM reservas WHERE id_cliente='$id_cliente'";
$resultR = mysqli_query($conn, $sql);


?>

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
      <h2>Mis Reservas</h2>
      <?php
      if (mysqli_num_rows($resultR) > 1) {
        while ($reserva = mysqli_fetch_assoc($resultR)) {

          $con = conexionDB();
          $id = $resultR['id_experiencia'];
          $sql = "SELECT * FROM `experiencias` WHERE id='$id'";

          $experiencia = mysqli_fetch_assoc($resultR);
          $nombreExpe = $experiencia['nombre'];
          $precioExpe = $experiencia['precio'];
          $cantidad = $reserva['cantidad'];


          echo '<article>';
          echo '<figure>';
          echo '<img src="' . $nombreExpe . '" alt="' . $nombreExpe . '">';
          echo '<figcaption>' . $nombreExpe . '</figcaption>';
          echo '</figure>';
          echo '<p>€' . $precioExpe . ' per person</p>';
          echo '<p>' . $cantidad . ' u</p>';
          echo '<button onclick="cancelarReserva(' . $reserva['id'] . ')">Cancelar</button>';
          echo '<button onclick="modificarReserva(' . $reserva['id'] . ')">Modificar</button>';
          echo '</article>';
        }
      } else if (mysqli_num_rows($resultR) == 1) {

        $con = conexionDB();
        $id = $resultR['id_experiencia'];
        $sql = "SELECT * FROM `experiencias` WHERE id='$id'";

        $experiencia = mysqli_fetch_assoc($resultR);
        $nombreExpe = $experiencia['nombre'];
        $precioExpe = $experiencia['precio'];
        $cantidad = $reserva['cantidad'];


        echo '<article>';
        echo '<figure>';
        echo '<img src="' . $nombreExpe . '" alt="' . $nombreExpe . '">';
        echo '<figcaption>' . $nombreExpe . '</figcaption>';
        echo '</figure>';
        echo '<p>€' . $precioExpe . ' per person</p>';
        echo '<p>' . $cantidad . ' u</p>';
        echo '<button onclick="cancelarReserva(' . $reserva['id'] . ')">Cancelar</button>';
        echo '<button onclick="modificarReserva(' . $reserva['id'] . ')">Modificar</button>';
        echo '</article>';
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