<?php
include 'functions.php';
session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}
$conn = conexionDB();

// Fetch user data
$id = $_SESSION['usuario'];
$sql = "SELECT * FROM clientes WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultP = mysqli_stmt_get_result($stmt);
$rowP = mysqli_fetch_assoc($resultP);

// Fetch user bookings
$sql = "SELECT * FROM reservas WHERE id_cliente=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultR = mysqli_stmt_get_result($stmt);
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles/general.css">
  <link rel="stylesheet" href="styles/profile.css">
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
      <a class="boton" href="login.php"><?= htmlspecialchars($login_text, ENT_QUOTES, 'UTF-8') ?></a>
    </nav>
  </header>

  <main>
    <a href="notification_list.php">List of notifications</a>
    <h2>My Bookings</h2>
    <section>
      <?php
      if (mysqli_num_rows($resultR) > 1) {
        while ($reserva = mysqli_fetch_assoc($resultR)) {

          $id = $reserva['id_anuncio'];
          $sql = "SELECT * FROM `experiencias` WHERE id=?";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($stmt, "i", $id);
          mysqli_stmt_execute($stmt);
          $experiencia = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
          $nombreExpe = htmlspecialchars($experiencia['nombre'], ENT_QUOTES, 'UTF-8');
          $precioExpe = htmlspecialchars($experiencia['precio'], ENT_QUOTES, 'UTF-8');
          $cantidad = htmlspecialchars($reserva['cantidad'], ENT_QUOTES, 'UTF-8');
      ?>
          <article>
            <h2><?= $nombreExpe ?></h2>
            <section class="info-container">
              <p><?= htmlspecialchars($reserva['fecha'], ENT_QUOTES, 'UTF-8') ?></p>
              <p><?= $cantidad ?> tickets</p>
              <p><?= $precioExpe ?>€ per person</p>
              <p>Total: <?= number_format($precioExpe * $cantidad, 2) ?>€</p>
            </section>
            <form action="cancelar_reserva.php" method="post" class="reservaForm">
              <input type="hidden" class="exp" name="exp" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
              <button type="submit" name="accion" value="cancelar" aria-label="For removing the booking">Cancel</button>
              <button type="submit" name="accion" value="modificar" aria-label="For modifying the data of your booking">Modify</button>
            </form>
          </article>

        <?php
        }
      } else if (mysqli_num_rows($resultR) == 1) {
        $reserva = mysqli_fetch_assoc($resultR);
        $id = $reserva['id_anuncio'];
        $sql = "SELECT * FROM `experiencias` WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $experiencia = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        $nombreExpe = htmlspecialchars($experiencia['nombre'], ENT_QUOTES, 'UTF-8');
        $precioExpe = htmlspecialchars($experiencia['precio'], ENT_QUOTES, 'UTF-8');
        $cantidad = htmlspecialchars($reserva['cantidad'], ENT_QUOTES, 'UTF-8');
        ?>

        <article>
          <h2><?= $nombreExpe ?></h2>
          <section class="info-container">
            <p><?= htmlspecialchars($reserva['fecha'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= $cantidad ?> tickets</p>
            <p><?= $precioExpe ?>€ per person</p>
            <p>Total: <?= number_format($precioExpe * $cantidad, 2) ?>€</p>
          </section>

          <form action="cancelar_reserva.php" method="post" class="reservaForm">
            <input type="hidden" class="exp" name="exp" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit" name="accion" value="cancelar" aria-label="For removing the booking">Cancel</button>
            <button type="submit" name="accion" value="modificar" aria-label="For modifying the data of your booking">Modify</button>
          </form>
        </article>

      <?php
      } else {
        echo '<p>Your booking list is empty.</p>';
      }
      ?>
    </section>
  </main>

  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo Sánchez Gómez</p>
  </footer>

  <script>
    document.querySelectorAll('.reservaForm button').forEach(function(button) {
      button.addEventListener('click', function(event) {
        var accion = event.target.value;
        if (accion === 'cancelar') {
          if (!confirm('Are you sure you want to cancel this reservation?')) {
            event.preventDefault();
          }
        } else if (accion === 'modificar') {
          if (!confirm('Are you sure you want to modify this reservation?')) {
            event.preventDefault();
          }
        }
      });
    });
  </script>

</body>

</html>