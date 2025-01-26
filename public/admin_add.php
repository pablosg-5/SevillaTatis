<?php
include 'functions.php';
session_start();
$login_text = isset($_SESSION['admin']) ? 'Log out' : 'Log in';


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['option'])) {
        if ($_POST['option'] === 'cancel') {
            header("Location: admin_page.php");
            exit();
        } else if ($_POST['option'] === 'add') {
            $nombreExpe = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $precio = isset($_POST['precio']) ? floatval(trim($_POST['precio'])) : 0.0;
            $imagen = isset($_POST['imagen']) ? htmlspecialchars(trim($_POST['imagen'])) : '';
            $texto = isset($_POST['texto']) ? htmlspecialchars(trim($_POST['texto'])) : '';

            if ($nombreExpe === '' || $precio <= 0 || $imagen === '' || $texto === '') {
                echo "Todos los campos son obligatorios y deben tener datos válidos.";
                exit();
            }

            $con = conexionDB();
            $stmt = $con->prepare("INSERT INTO `experiencias`(`nombre`, `descripcion`, `precio`, `imagen`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $nombreExpe, $texto, $precio, $imagen);
            $stmt->execute();
            $stmt->close();
            $con->close();

            header("Location: admin_page.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

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
            <a class="boton" href="login.php"><?= htmlspecialchars($login_text) ?></a>
        </nav>
    </header>
    <main>
        <h2>Add new Experience</h2>
        <form action="admin_add.php" method="post">
            <label for="nombre">Name:</label>
            <input type="text" name="nombre" value="">
            <label for="imagen">Image:</label>
            <input type="text" name="imagen" value="">
            <label for="precio">Price:</label>
            <input type="text" name="precio" value="">
            <label for="texto">Description:</label>
            <input type="text" name="texto" value="">

            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <button type="submit" class="buttons" name="option" value="add">Add</button>
            <button type="submit" class="buttons" name="option" value="cancel">Cancel</button>
        </form>
    </main>
</body>

</html>