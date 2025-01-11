<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sevillatatis</title>
    <link rel="stylesheet" href="styles\new_account.css">
</head>

<body>
    <header>
        <h1>Hola, new_account</h1>
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
        <form action="new_account.php" method="post" enctype="multipart/form-data">
            <img src="../img/icon.jpg" alt="Profile">
            <h2 class="section">Create New Account</h2>

            <p>Name:</p>
            <input type="text" name="name" required>

            <p>Surname:</p>
            <input type="text" name="surname" required>

            <p>DNI:</p>
            <input type="text" name="dni" required>

            <p>Date of Birth:</p>
            <input type="date" name="birthdate" required>

            <p>Profile Picture:</p>
            <input type="file" name="profile_picture" accept="image/*">

            <p>Username:</p>
            <input type="text" name="username" required>

            <p>Password:</p>
            <input type="password" name="password" required>

            <p>Confirm Password:</p>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Create Account">
        </form>
    </main>

    <footer>
        <p>Universidad Pablo de Olavide - Alma Mater Studiorum Universita di Bologna</p>
        <p>By Pablo S&aacute;nchez G&oacute;mez</p>
    </footer>
</body>

</html>