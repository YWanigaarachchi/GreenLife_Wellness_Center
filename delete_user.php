<?php
session_start();
include("db.php"); // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: admin_clients.php");
        exit;
    } else {
        die("Error deleting user: " . $conn->error);
    }
} else {
    header("Location: admin_clients.php");
    exit;
}
?>
