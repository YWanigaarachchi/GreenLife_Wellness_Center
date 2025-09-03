<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <a href="view_users.php"><button>View All Users</button></a>
        <a href="view_appointments.php"><button>View Appointments</button></a>
        <a href="view_inquiries.php"><button>View Inquiries</button></a>
        <a href="logout.php"><button>Logout</button></a>
    </div>
</body>
</html>
