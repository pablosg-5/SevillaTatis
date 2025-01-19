<?php
include 'functions.php';
session_start();

if (isset($_POST['opcion'])) {
  if ($_POST['opcion'] == 'buy') {
    $_SESSION['id_experience'] = $_POST['id'];
    $_SESSION['num_tickets'] = $_POST['num_tickets'];
    $_SESSION['fecha']= $_POST['fecha'];


    header('Location: proceso_pago.php');
    exit();
  } else if ($_POST['opcion'] == 'cancel') {
    header('location: search.php');
    exit();
  }
}

$con = conexionDB();
$sql = 'SELECT * FROM experiencias WHERE `id`=' . $_POST['id_experience'] . ';';
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

?>

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
      <img src="<?= $row['imagen'] ?>" alt="<?= $row['nombre'] ?>">
      <figcaption><?= $row['nombre'] ?></figcaption>
    </figure>
    <form action="buy.php" method="post">
      <p><?= $row['descripcion'] ?></p>
      <p><?= $row['precio'] ?>€</p>

      <label for="fecha">Selecciona una fecha:</label>
      <input type="date" id="fecha" name="fecha" required>
      <select name="num_tickets" id="num_tickets">
        <?php
        for ($i = 1; $i <= 5; $i++) {
          $selected = ($i == 1) ? 'selected' : ''; 
          echo "<option value='$i' $selected>$i ticket" . ($i > 1 ? 's' : '') . "</option>";
        }
        ?>
      </select>
      <input type="hidden" name="opcion" id="opcion" value="">
      <input type="hidden" name="id" value="<?= $row['id']; ?>">
      <button type="submit" onclick="document.getElementById('opcion').value='buy';">BUY</button>
      <button type="submit" onclick="document.getElementById('opcion').value='cancel';">CANCEL</button>
    </form>

  </main>

  <footer>
    <p>Universidad Pablo de OlavideAlma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>