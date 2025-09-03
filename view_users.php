<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$sql = "SELECT id, name, email, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>All Registered Users</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td>
                <a href="delete_user.php?id=<?= $row['id'] ?>" 
                   onclick="return confirm('Are you sure you want to delete this user?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <a href="admin_dashboard.php"><button>Back to Dashboard</button></a>
</div>
</body>
</html>
