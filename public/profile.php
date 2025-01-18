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
  <link rel="stylesheet" href="styles\search.css">
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
    <section>
      <h2>Mis Reservas</h2>
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
            <button onclick="<?= cancelarReserva($reserva['id_anuncio']) ?>">Cancelar</button>
            <button onclick="modificarReserva(<?= $reserva['id_anuncio'] ?>)">Modificar</button>
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

          <!-- Botón de Cancelar con JavaScript -->
          <button onclick="return cancelarReserva(<?= $reserva['id_anuncio'] ?>)">Cancelar</button>

          <!-- Botón de Modificar con JavaScript -->
          <button onclick="modificarReserva(<?= $reserva['id_anuncio'] ?>)">Modificar</button>
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

<script>
function cancelarReserva(id) {
    if (confirm("¿Estás seguro de que deseas cancelar esta reserva?")) {
        fetch('cancelar_reserva.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Reserva cancelada correctamente.");
                document.getElementById('reserva-' + id).remove(); // Remueve el artículo de la vista
            } else {
                alert('Error al cancelar la reserva.');
            }
        });
    }
    return false; // Evita el comportamiento por defecto del botón
}
</script>