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
  <link rel="stylesheet" href="styles/general.css">
  <link rel="stylesheet" href="styles/who.css">
</head>

<body>
  <header>
    <h1>Sevillatatis</h1>
    <nav>
      <ul>
        <li><a href="profile.php" aria-label="Go to user profile">Profile</a></li>
        <li><a href="search.php" aria-label="Search for experiences">Search experiences</a></li>
        <li><a href="about.php" aria-label="Learn more about who we are">Who we are</a></li>
        <li><a href="more.php" aria-label="Discover more options">More</a></li>
      </ul>
      <a class="boton" href="login.php" aria-label="Log in or log out"><?= $login_text ?></a>
    </nav>
  </header>

  <main>
    <!-- Article describing the purpose and background of Sevillatatis -->
    <article>
      <p>My name is Pablo Sánchez Gómez, I was born in Seville, and I study Computer Engineering in Seville. I started my degree because I am passionate about technology and the endless possibilities it offers. I am currently doing a half-year Erasmus in Cesena, Italy. I chose this destination because of my interest in Italy's gastronomy and culture, and I wanted to explore the country more deeply.</p>
      <p>Sevillatatis is a project for my Web-related Technologies course, which allowed me the freedom to develop a project of my choice. My goal is to inspire my professors to visit Seville, just as I have enjoyed their country and city. Additionally, this project showcases my love for Seville.</p>
    </article>

    <!-- Figure with an image and caption providing information about the author -->
    <figure>
      <img src="../img/yo.jpg" alt="Picture of Pablo Sánchez Gómez" aria-label="A photo of Pablo Sánchez Gómez">
      <figcaption>
        Name: Pablo Sánchez Gómez<br>
        Age: 24<br>
        Birthdate: 12/01/2001
      </figcaption>
    </figure>
  </main>

  <footer>
    <p>Universidad Pablo de Olavide | Alma Mater Studiorum Università di Bologna</p>
    <p>By Pablo Sánchez Gómez</p>
  </footer>
</body>

</html>