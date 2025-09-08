<?php
include("db.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO feedback (user_id, subject, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $subject, $message);
    $stmt->execute();

    echo "Feedback sent successfully.";
}
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
