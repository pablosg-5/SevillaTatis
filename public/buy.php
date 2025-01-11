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
    <h1>Hola, buy</h1>
    <!-- Logo, menú de navegación -->

  </header>
  <main>
    <select name="num_tickets" id="num_tickets">
      <?php
      // Generamos las opciones de la lista desplegable
      for ($i = 1; $i <= 5; $i++) {
        $selected = ($i == 1) ? 'selected' : ''; // Seleccionamos la opción 1 por defecto
        echo "<option value='$i' $selected>$i ticket" . ($i > 1 ? 's' : '') . "</option>";
      }
      ?>
    </select>
  </main>
  <footer>
    <!-- Información de contacto, enlaces rápidos -->
  </footer>
</body>

</html>