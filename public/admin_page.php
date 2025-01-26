<?php
include 'functions.php';
session_start();
$login_text = isset($_SESSION['admin']) ? 'Log out' : 'Log in';

// Redirect if not logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$con = conexionDB();

$searchTerm = isset($_POST['search']) ? htmlspecialchars(trim($_POST['search'])) : '';
$filtro = isset($_POST['filtro']) ? htmlspecialchars(trim($_POST['filtro'])) : '';

// Build SQL query based on filters
$sql = "SELECT * FROM experiencias";
$conditions = [];

if (!empty($searchTerm)) {
    $conditions[] = "nombre LIKE ?";
}

if ($filtro === 'precio') {
    $sql .= " ORDER BY precio DESC";
} elseif ($filtro === 'az') {
    $sql .= " ORDER BY nombre ASC";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Prepare and execute the query
$stmt = $con->prepare($sql);
if (!empty($searchTerm)) {
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("s", $searchTerm); // 's' is for string
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sevillatatis</title>
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/search.css">
    <link rel="stylesheet" href="styles/admin_page.css">
</head>

<body>
    <header>
        <h1>Sevillatatis</h1>
        <nav>
            <ul>
                <li><a href="admin_page.php">Search experiences</a></li>
            </ul>
            <a class="boton" href="login.php" aria-label="Log in or log out"><?= htmlspecialchars($login_text) ?></a>
        </nav>
    </header>

    <main>
        <section>
            <form method="post" action="admin_page.php" class="barra">
                <h2>Experiences</h2>
                <section class="top-row">
                    <input id="search" name="search" type="text" placeholder="Search..." value="<?= htmlspecialchars($searchTerm) ?>" aria-label="Search experiences">
                    <input type="hidden" id="filtro" name="filtro" value="">
                    <input type="image" src="../img/lupa.jpg" class="lupa" alt="Search" aria-label="Search button">
                </section>
                <section class="buttons-row">
                    <input type="submit" value="Price" onclick="document.getElementById('filtro').value='precio';" aria-label="Sort by price">
                    <input type="submit" value="A-Z" onclick="document.getElementById('filtro').value='az';" aria-label="Sort by name A-Z">
                </section>
            </form>

            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <article>
                        <form action="admin_modify.php" method="post">
                            <figure>
                                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                <input type="image" src="<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['nombre']) ?>" name="<?= htmlspecialchars($row['nombre']) ?>" aria-label="View experience <?= htmlspecialchars($row['nombre']) ?>">
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

        <a href="admin_add.php" class="button" aria-label="Add new experience">ADD NEW EXPERIENCE</a>
    </main>
</body>

</html>