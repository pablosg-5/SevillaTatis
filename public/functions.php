<?php

function conexionDB() {
    $con = mysqli_connect("localhost", "root", "");

    if (!$con) {
        die("Error al crear la conexión: " . mysqli_connect_error($con));
    }

    $db = mysqli_select_db($con, "sevillatatis");

    if (!$db) {
        mysqli_close($con);
        die("Error al crear la conexión a la base de datos: " . mysqli_error($con));
    }

    return $con;
}