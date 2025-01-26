<?php
session_start();
$login_text = isset($_SESSION['usuario']) ? 'Log out' : 'Log in';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis</title>
  <link rel="stylesheet" href="styles/sevilla.css">
  <link rel="stylesheet" href="styles/general.css">
</head>

<body>
  <header>
    <h1>Sevillatatis</h1>
    <nav>
      <ul>
        <li><a href="profile.php" aria-label="Go to profile page">Profile</a></li>
        <li><a href="search.php" aria-label="Search for experiences">Search experiences</a></li>
        <li><a href="about.php" aria-label="Learn about who we are">Who we are</a></li>
        <li><a href="more.php" aria-label="Learn more">More</a></li>
      </ul>
      <a class="boton" href="login.php" aria-label="<?= htmlspecialchars($login_text) ?>"><?= $login_text ?></a>
    </nav>
  </header>

  <main>
    <section>
      <figure>
        <img src="../img/nodo.jpg" alt="Flag of Seville">
        <figcaption>The Flag</figcaption>
      </figure>
      <p>The flag of Seville consists of two horizontal stripes of equal size, red on top and green on the bottom. The red stripe represents the city's history and culture, while the green stripe symbolizes its natural beauty and fertile lands. The flag's design reflects Seville's rich heritage and vibrant spirit, making it a proud emblem of the city.</p>
    </section>

    <section>
      <figure>
        <img src="../img/ciudad.jpg" alt="Seville's historical landmarks">
        <figcaption>History and Culture</figcaption>
      </figure>
      <p>Seville, the capital of Andalusia, boasts a history spanning over 2,000 years. Founded as the Roman city of Hispalis, it later became a significant Moorish hub before being reclaimed during the Christian Reconquest. This blend of cultures has shaped the city's iconic landmarks, such as the Giralda, the Alcázar, and the Archivo de Indias, all recognized as UNESCO World Heritage Sites. Seville is also the birthplace of flamenco, a passionate art form echoing its rich cultural heritage. The city's festivals, such as Holy Week (Semana Santa) and the April Fair (Feria de Abril), attract visitors worldwide, offering a unique glimpse into Andalusian traditions. From literature to architecture, Seville's cultural legacy remains deeply influential.</p>
    </section>

    <section>
      <figure>
        <img src="../img/plaza_toro.jpg" alt="Seville as a tourist destination">
        <figcaption>Touristic Destination</figcaption>
      </figure>
      <p>Seville, the capital of Andalusia, boasts a history spanning over 2,000 years. Founded as the Roman city of Hispalis, it later became a significant Moorish hub before being reclaimed during the Christian Reconquest. This blend of cultures has shaped the city's iconic landmarks, such as the Giralda, the Alcázar, and the Archivo de Indias, all recognized as UNESCO World Heritage Sites. Seville is also the birthplace of flamenco, a passionate art form echoing its rich cultural heritage. The city's festivals, such as Holy Week (Semana Santa) and the April Fair (Feria de Abril), attract visitors worldwide, offering a unique glimpse into Andalusian traditions. From literature to architecture, Seville's cultural legacy remains deeply influential.</p>
    </section>
  </main>

  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo Sánchez Gómez</p>
  </footer>
</body>

</html>