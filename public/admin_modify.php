<?php
include 'functions.php';
session_start();
$login_text = isset($_SESSION['admin']) ? 'Log out' : 'Log in';

// Check if the user is an admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['option'])) {
        if ($_POST['option'] === 'cancel') {
            header("Location: admin_page.php");
            exit();
        } else if ($_POST['option'] === 'modify') {
            // Validate received data
            $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $imagen = isset($_POST['imagen']) ? htmlspecialchars(trim($_POST['imagen'])) : '';
            $precio = isset($_POST['precio']) ? floatval(trim($_POST['precio'])) : 0.0;
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

            // Basic validation
            if (empty($nombre) || empty($imagen) || $precio <= 0 || empty($descripcion) || $id <= 0) {
                echo "All fields are required and must be valid.";
                exit();
            }

            // Connect to the database and prepared statement for updating the experience
            $con = conexionDB();
            $stmt = $con->prepare("UPDATE experiencias SET nombre=?, imagen=?, precio=?, descripcion=? WHERE id=?");
            $stmt->bind_param("ssdis", $nombre, $imagen, $precio, $descripcion, $id); // Parameters: string, string, double, string, integer
            $stmt->execute();
            $stmt->close();
            $con->close();

            header("Location: admin_page.php");
            exit();
        } else if ($_POST['option'] === 'delete') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            if ($id > 0) {
                // Connect to the database and prepared statement for deleting the experience
                $con = conexionDB();
                $stmt = $con->prepare("DELETE FROM reservas WHERE id_anuncio = ?");
                $stmt->bind_param("i", $id); // Integer parameter
                $stmt->execute();

                $stmt = $con->prepare("DELETE FROM experiencias WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();

                $stmt->close();
                $con->close();

                header("Location: admin_page.php");
                exit();
            } else {
                echo "Invalid ID.";
                exit();
            }
        }
    }
}

// Fetch the experience details from the database
$con = conexionDB();
$stmt = $con->prepare("SELECT * FROM experiencias WHERE id = ?");
$stmt->bind_param("i", $_POST['id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sevillatatis</title>
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/admin_experience.css">
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
        <h2>Modify Experience</h2>
        <form action="admin_modify.php" method="post">
            <label for="nombre">Name:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($row['nombre']) ?>" aria-label="Experience name">
            <label for="imagen">Image URL:</label>
            <input type="text" name="imagen" value="<?= htmlspecialchars($row['imagen']) ?>" aria-label="Experience image URL">
            <label for="precio">Price:</label>
            <input type="text" name="precio" value="<?= htmlspecialchars($row['precio']) ?>" aria-label="Experience price">
            <label for="descripcion">Description:</label>
            <textarea class="texto" name="descripcion" aria-label="Experience description"><?= htmlspecialchars($row['descripcion']) ?></textarea>
            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">

            <button type="submit" class="buttons" name="option" value="modify" aria-label="Modify this experience">Modify</button>
            <button type="submit" class="buttons" name="option" value="delete" aria-label="Delete this experience">Delete</button>
            <button type="submit" class="buttons" name="option" value="cancel" aria-label="Cancel changes">Cancel</button>
        </form>
    </main>
</body>

</html>