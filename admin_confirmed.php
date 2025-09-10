<?php 
session_start();
include("db.php");

// Only allow admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch confirmed appointments
$sql = "
    SELECT a.appointment_id, 
           u.first_name, u.last_name, 
           t.name AS therapist_name, 
           s.name AS service_name, 
           a.appointment_date, a.appointment_time, 
           a.status, a.notes
    FROM appointments a
    JOIN users u ON a.client_id = u.user_id
    JOIN therapists t ON a.therapist_id = t.therapist_id
    JOIN services s ON a.service_id = s.service_id
    WHERE a.status='confirmed'
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmed Appointments - Admin</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:Arial,sans-serif;display:flex;min-height:100vh;background:#ecf0f1;}
.sidebar{width:220px;background:#2c3e50;color:#fff;padding:20px 0;flex-shrink:0;}
.sidebar h2{text-align:center;margin-bottom:20px;font-size:18px;}
.sidebar a{display:block;color:#fff;padding:12px 20px;text-decoration:none;transition:background 0.3s;}
.sidebar a:hover{background:#34495e;}
.main{flex:1;padding:30px;}
h1{margin-bottom:20px;color:#2c3e50;}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#34495e;color:#fff;}
tr:hover{background:#f4f6f7;}
</style>
</head>
<body>
<div class="sidebar">
<h2>Admin Panel</h2>
<a href="admin_dashboard.php">Dashboard</a>
<a href="admin_appointments.php">All Appointments</a>
<a href="admin_confirmed.php">Confirmed</a>
<a href="admin_cancelled.php">Cancelled</a>
<a href="logout.php">Log Out</a>
</div>
<div class="main">
<h1>✅ Confirmed Appointments</h1>
<table>
<tr>
<th>ID</th>
<th>Client</th>
<th>Therapist</th>
<th>Service</th>
<th>Date</th>
<th>Time</th>
<th>Notes</th>
</tr>
<?php if ($result && $result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['appointment_id']); ?></td>
<td><?= htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
<td><?= htmlspecialchars($row['therapist_name']); ?></td>
<td><?= htmlspecialchars($row['service_name']); ?></td>
<td><?= htmlspecialchars(date("d M Y", strtotime($row['appointment_date']))); ?></td>
<td><?= htmlspecialchars(date("h:i A", strtotime($row['appointment_time']))); ?></td>
<td><?= htmlspecialchars($row['notes']); ?></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="7" style="text-align:center;">No confirmed appointments found</td></tr>
<?php endif; ?>
</table>
</div>
</body>
</html>
