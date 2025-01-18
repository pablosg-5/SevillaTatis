<?php
include 'functions.php';
header('Content-Type: application/json'); // Para devolver datos en formato JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $conn = conexionDB();

        // Eliminar la reserva de la base de datos
        $sql = "DELETE FROM reservas WHERE id_anuncio = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar la reserva']);
        }

        mysqli_close($conn);
    }
}
?>
