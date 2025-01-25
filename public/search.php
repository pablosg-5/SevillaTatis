<?php
include 'functions.php';
session_start();

$con = conexionDB();

// Inicializar variables de consulta
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

// Construir la consulta SQL según los filtros
$sql = "SELECT * FROM experiencias";
if (!empty($searchTerm)) {
  $sql .= " WHERE nombre LIKE '%$searchTerm%'";
}

if ($filtro === 'precio') {
  $sql .= " ORDER BY precio DESC";
} elseif ($filtro === 'az') {
  $sql .= " ORDER BY nombre ASC";
}

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles\general.css">
  <link rel="stylesheet" href="styles\search.css">

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
      <a id="boton" href="login.php">Log in/Log out</a>
    </nav>
  </header>
  <main>
    <section>


      <form method="post" action="search.php" class="barra">
        <h2>Experiences</h2>
        <section class="top-row">
          <input id="search" name="search" type="text" placeholder="Buscar..." value="<?= htmlspecialchars($searchTerm) ?>">
          <input type="hidden" id="filtro" name="filtro" value="">
          <input type="image" src="../img/lupa.jpg" class="lupa" alt="Buscar">
        </section>
        <section class="buttons-row">
          <input type="submit" value="Precio" onclick="document.getElementById('filtro').value='precio';">
          <input type="submit" value="A-Z" onclick="document.getElementById('filtro').value='az';">
        </section>
      </form>

      <?php
      // Mostrar resultados
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
          <article>
            <form action="buy.php" method="post">
              <figure>
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="image" src="<?= $row['imagen'] ?>" alt="<?= htmlspecialchars($row['nombre']) ?>" name="<?= htmlspecialchars($row['nombre']) ?>">
                <figcaption><?= htmlspecialchars($row['nombre']) ?></figcaption>
                <p>€<?= htmlspecialchars($row['precio']) ?> per person</p>
              </figure>
            </form>
          </article>

      <?php
        }
      } else {
        echo "<p>No se encontraron experiencias.</p>";
      }
      ?>
    </section>
  </main>
  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Università di Bologna</p>
    <p>By Pablo S&aacute;nchez G&oacute;mez</p>
  </footer>
</body>

</html>