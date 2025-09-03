<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$sql = "SELECT i.id, u.name AS client_name, i.message 
        FROM inquiries i
        JOIN users u ON i.client_id = u.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Inquiries</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>All Client Inquiries</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Message</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['client_name']) ?></td>
            <td><?= htmlspecialchars($row['message']) ?></td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <a href="admin_dashboard.php"><button>Back to Dashboard</button></a>
</div>
</body>
</html>
