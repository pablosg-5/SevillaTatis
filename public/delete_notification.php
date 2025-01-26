<?php
include 'functions.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario'];

$conn = conexionDB();

if (isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];

    $query = "DELETE FROM notifications WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $notification_id, $user_id);
    $stmt->execute();

    header("Location: notification_list.php");
    exit();
} else {
    header("Location: notification_list.php");
    exit();
}
