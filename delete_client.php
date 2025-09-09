<?php
session_start();
include("db.php");

// ✅ Get client ID
if (!isset($_GET['id'])) {
    die("❌ No client ID provided.");
}
$client_id = intval($_GET['id']);

// ✅ Delete client
$sql = "DELETE FROM users WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);

if ($stmt->execute()) {
    header("Location: admin_clients.php?msg=Client deleted successfully");
    exit;
} else {
    echo "❌ Delete failed: " . $conn->error;
}
?>
