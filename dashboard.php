<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['user_name'];
$role = $_SESSION['user_role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - GreenLife</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
    <p>Role: <strong><?php echo htmlspecialchars($role); ?></strong></p>

    <a href="appointment.php"><button>Book Appointment</button></a>
    <a href="inquiry.php"><button>Submit Inquiry</button></a>
    <a href="logout.php"><button>Logout</button></a>
</div>
</body>
</html>
