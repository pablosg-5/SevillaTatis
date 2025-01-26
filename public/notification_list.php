<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['usuario'];

$conn = conexionDB();

$query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sevillatatis - Notifications</title>
  <link rel="stylesheet" href="styles/general.css">
  <link rel="stylesheet" href="styles/notification.css">
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
      <a class="boton" href="login.php" aria-label="Log out">Log out</a>
    </nav>
  </header>

  <main>
    <h2>Your Notifications</h2>

    <?php if ($result->num_rows > 0): ?>
      <ul class="notifications-list">
        <?php while ($row = $result->fetch_assoc()): ?>
          <li class="notification-item">
            <p><?= htmlspecialchars($row['message']) ?></p>
            <span><?= $row['created_at'] ?></span>
            <form method="POST" action="delete_notification.php" style="display: inline;">
              <input type="hidden" name="notification_id" value="<?= $row['id'] ?>">
              <button type="submit" class="delete-button">Delete</button>
            </form>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>No notifications found.</p>
    <?php endif; ?>
  </main>

  <footer>
    <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
    <p>By Pablo Sánchez Gómez</p>
  </footer>

</body>

</html>