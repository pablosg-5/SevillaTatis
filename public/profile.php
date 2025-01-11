<?php

require('functions.php');
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

// Conexión a la base de datos (reemplazar con tus credenciales)
include 'functions.php';
$conn = conexionDB();

// Obtener datos del usuario
$usuario = $_SESSION['usuario'];
$sql = "SELECT * FROM clientes WHERE nombre_usuario='$usuario'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Obtener las reservas del usuario
$sql = "SELECT r.id, e.nombre, e.precio, r.cantidad, r.fecha_reserva FROM reservas r
        INNER JOIN experiencias e ON r.experiencia_id = e.id
        WHERE r.cliente_id = $row[id]";
$result = mysqli_query($conn, $sql);

// Generar el HTML dinámico
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
      if (mysqli_num_rows($result) > 0) {
        while ($reserva = mysqli_fetch_assoc($result)) {
          echo '<article>';
          echo '<figure>';
          echo '<img src="../img/' . $reserva['nombre'] . '.jpg" alt="' . $reserva['nombre'] . '">';
          echo '<figcaption>' . $reserva['nombre'] . '</figcaption>';
          echo '</figure>';
          echo '<p>€' . $reserva['precio'] . ' per person</p>';
          echo '<p>' . $reserva['cantidad'] . ' u</p>';
          echo '<button onclick="cancelarReserva(' . $reserva['id'] . ')">Cancelar</button>';
          echo '<button onclick="modificarReserva(' . $reserva['id'] . ')">Modificar</button>';
          echo '</article>';
        }
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