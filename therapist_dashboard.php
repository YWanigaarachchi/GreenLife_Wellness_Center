<?php
session_start();

// Redirect if not logged in or not a therapist
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'therapist') {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['user_name'];

include("db.php");

// SQL query to fetch therapist's appointments
$sql = "SELECT a.id, u.name AS client_name, a.service, a.date
        FROM appointments a
        JOIN users u ON a.client_id = u.id
        WHERE a.therapist = ?
        ORDER BY a.date ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Therapist Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($name); ?> (Therapist)</h2>

    <h3>Your Appointments</h3>
    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Client Name</th>
                <th>Service</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['service']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No appointments yet.</p>
    <?php endif; ?>

    <br>
    <a href="logout.php"><button>Logout</button></a>
</div>
</body>
</html>
