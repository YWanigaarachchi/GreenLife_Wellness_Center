<?php
session_start();
if ($_SESSION['user_role'] !== 'client') {
    header("Location: login.php");
    exit;
}
$name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html>
<head><title>Client Dashboard</title></head>
<body>
    <h2>Welcome, <?php echo $name; ?> (Client)</h2>
    <a href="appointment.php">Book Appointment</a><br>
    <a href="inquiry.php">Submit Inquiry</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>