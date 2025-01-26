<?php
include 'functions.php';
session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';

$con = conexionDB();

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

$sql = "SELECT * FROM experiencias";
$params = [];

// Apply search term filter if entered
if (!empty($searchTerm)) {
  $sql .= " WHERE nombre LIKE ?";  // Filter by name
  $params[] = "%" . $searchTerm . "%";
}


if ($filtro === 'precio') {
  $sql .= " ORDER BY precio DESC";  // Sort by price
} elseif ($filtro === 'az') {
  $sql .= " ORDER BY nombre ASC";  // Sort alphabetically
}

$stmt = mysqli_prepare($con, $sql);

if (!empty($searchTerm)) {
  mysqli_stmt_bind_param($stmt, 's', $params[0]);  // Bind search term parameter
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles/general.css">
  <link rel="stylesheet" href="styles/search.css">
  <script>
    // Wait for the document to load before attaching event listeners
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');

      // Form validation: Ensure at least one search term or filter is provided
      form.addEventListener('submit', function(event) {
        const searchInput = document.querySelector('.search');
        if (searchInput.value.trim() === '' && document.getElementById('filtro').value === '') {
          alert('Please enter a search term or select a filter.');
          event.preventDefault();
        }
      });

      // Intersection observer to animate elements when they appear in view
      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, {
        threshold: 0.5
      });

      // Observe all elements with the class 'animate'
      document.querySelectorAll('.animate').forEach(element => {
        observer.observe(element);
      });
    });
  </script>
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
      <a class="boton" href="login.php"><?= $login_text ?></a>
    </nav>
  </header>

  <main>
    <section>
      <form method="post" action="search.php" class="barra">
        <h2>Experiences</h2>
        <section class="top-row">
          <input class="search" name="search" type="text" placeholder="Search..." value="<?= htmlspecialchars($searchTerm) ?>" aria-label="Search for experiences">
          <input type="hidden" id="filtro" name="filtro" value="<?= htmlspecialchars($filtro) ?>">
          <input type="image" src="../img/lupa.jpg" class="lupa" alt="Search" aria-label="Click to search">
        </section>
        <section class="buttons-row">
          <!-- Button to filter by price -->
          <input type="submit" value="By Price" onclick="document.getElementById('filtro').value='precio';" aria-label="Order advertisements by price">
          <!-- Button to filter alphabetically -->
          <input type="submit" value="By A-Z" onclick="document.getElementById('filtro').value='az';" aria-label="Order advertisements by name">
        </section>
      </form>

      <?php
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
          <!-- Loop through results and display each experience -->
          <article class="animate">
            <form action="buy.php" method="post">
              <figure>
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                <input type="image" src="<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['nombre']) ?>" name="<?= htmlspecialchars($row['nombre']) ?>" aria-label="<?= htmlspecialchars($row['nombre']) ?>">
                <figcaption><?= htmlspecialchars($row['nombre']) ?></figcaption>
                <p>€<?= htmlspecialchars($row['precio']) ?> per person</p>
              </figure>
            </form>
          </article>
      <?php
        }
      } else {
        echo "<p>No experiences found.</p>";
      }
      ?>
    </section>
  </main>

  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Università di Bologna</p>
    <p>By Pablo Sánchez Gómez</p>
  </footer>

  <style>
    /* Animation styles for fading in elements */
    .animate {
      opacity: 0;
      transform: translateY(50px);
      transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .animate.visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</body>

</html>