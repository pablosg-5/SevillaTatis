<?php
include 'functions.php';
session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';

if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
  exit();
}

// Error message
$error_message = '';
$success_message = '';

// Validate POST input and protect against SQL injection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && ctype_digit($_POST['id'])) {
  $con = conexionDB();

  // Prepare query to prevent SQL injection
  $stmt = $con->prepare('SELECT * FROM experiencias WHERE id = ?');
  $stmt->bind_param('i', $_POST['id']);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if (!$row) {
    die('Error: Experience not found.');
  }

  // Process options (buy or cancel)
  if (isset($_POST['opcion'])) {
    if ($_POST['opcion'] === 'buy') {
      if (empty($_POST['fecha'])) {
        $error_message = 'Please select a date before continuing.';
      } else {
        $_SESSION['id_experience'] = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $_SESSION['num_tickets'] = htmlspecialchars($_POST['num_tickets'], ENT_QUOTES, 'UTF-8');
        $_SESSION['fecha'] = htmlspecialchars($_POST['fecha'], ENT_QUOTES, 'UTF-8');

        if (isset($_SESSION['usuario'])) {
          $usuario_id = $_SESSION['usuario'];
          $mensaje = "You have successfully reserved the experience: " . $row['nombre'];
          $fecha_notificacion = date('Y-m-d H:i:s');

          $stmt = $con->prepare('INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, ?)');
          $stmt->bind_param('iss', $usuario_id, $mensaje, $fecha_notificacion);
          $stmt->execute();

          $success_message = "Reservation successful! Check your notifications.";

          // Redirect to payment page after a short delay
          echo "<script>
                  alert('Reservation successful! Check your notifications.');
                  setTimeout(function() {
                      window.location.href = 'proceso_pago.php';
                  }, 3000);
                </script>";
        }

        exit();
      }
    } elseif ($_POST['opcion'] === 'cancel') {
      header('Location: search.php');
      exit();
    }
  }
} else {
  die('Error: Invalid input data.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles/general.css">
  <link rel="stylesheet" href="styles/buy.css">
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
    <figure>
      <img src="<?= htmlspecialchars($row['imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8') ?>">
      <figcaption><?= htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8') ?></figcaption>
    </figure>

    <form action="buy.php" method="post">
      <p><?= htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
      <p><?= htmlspecialchars($row['precio'], ENT_QUOTES, 'UTF-8') ?>€ per person</p>
      <p>Total: <span id="total"><?= htmlspecialchars($row['precio'], ENT_QUOTES, 'UTF-8') ?></span>€</p>

      <!-- Error message for accessibility -->
      <?php if (!empty($error_message)) : ?>
        <div class="error-message" role="alert"><?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <!-- Success message for the reservation -->
      <?php if (!empty($success_message)) : ?>
        <div class="success-message" role="alert"><?= htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <label for="fecha">Select a date:</label>
      <input type="date" id="fecha" name="fecha" required aria-required="true">

      <label for="num_tickets">Number of tickets:</label>
      <select name="num_tickets" id="num_tickets" onchange="updateTotal()" aria-label="Select the number of tickets">
        <?php
        for ($i = 1; $i <= 5; $i++) {
          echo "<option value='$i'>$i ticket" . ($i > 1 ? 's' : '') . "</option>";
        }
        ?>
      </select>
      <input type="hidden" name="opcion" id="opcion" value="">
      <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">

      <button type="submit" onclick="document.getElementById('opcion').value='buy';">Buy</button>
      <button type="submit" onclick="document.getElementById('opcion').value='cancel';">Cancel</button>
    </form>
  </main>

  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Università di Bologna</p>
    <p>By Pablo Sánchez Gómez</p>
  </footer>

  <script>
    function updateTotal() {
      const precio = <?= json_encode($row['precio'], JSON_HEX_TAG); ?>;
      const numTickets = document.getElementById('num_tickets').value;
      const total = (precio * numTickets).toFixed(2);
      const totalElement = document.getElementById('total');
      totalElement.innerText = total;
      totalElement.style.color = '#4CAF50';
    }
  </script>
</body>

</html>