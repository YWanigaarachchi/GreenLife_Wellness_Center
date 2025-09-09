<?php 
session_start();
include("db.php"); // make sure db.php connects to your DB

// Only allow admins
//if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//    header("Location: login.php");
//    exit;
//}

// Fetch appointments with client + therapist info
$sql = "
    SELECT a.appointment_id, 
           u.first_name, u.last_name, 
           a.appointment_date, a.appointment_time, 
           a.status, t.therapist_name
    FROM appointments a
    JOIN users u ON a.client_id = u.user_id
    JOIN therapists t ON a.therapist_id = t.therapist_id
    ORDER BY a.appointment_date, a.appointment_time
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointments - Admin</title>
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
    <a href="admin_clients.php">Manage Clients</a>
    <a href="admin_appointments.php">Appointments</a>
    <a href="admin_inquiries.php">Inquiries</a>
    <a href="admin_reports.php">Reports</a>
    <a href="logout.php">Log Out</a>
  </div>

  <div class="main">
    <h1>📅 Appointments</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Therapist</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
            <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['therapist_name']); ?></td>
            <td><?php echo htmlspecialchars(date("d M Y", strtotime($row['appointment_date']))); ?></td>
            <td><?php echo htmlspecialchars(date("h:i A", strtotime($row['appointment_time']))); ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6" style="text-align:center;">No appointments found</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
