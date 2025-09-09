<?php 
session_start();
include("db.php"); // make sure this file contains your DB connection

// Only allow admins
//if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//    header("Location: login.php");
//    exit;
//}

// Fetch all clients from DB
$sql = "SELECT user_id, first_name, last_name, email, phone FROM users WHERE role='client'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Clients - Admin</title>
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
    button{padding:6px 12px;margin:0 4px;border:none;border-radius:4px;cursor:pointer;}
    .edit-btn{background:#27ae60;color:#fff;}
    .delete-btn{background:#c0392b;color:#fff;}
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_clients.php">Manage Clients</a>
    <a href="admin_appointments.php">Appointments</a>
    <a href="admin_inquiries.php">Inquiries</a>
    <a href="admin_messages.php">Messages</a>
    <a href="admin_reports.php">Reports</a>
    <a href="logout.php">Log Out</a>
  </div>

  <div class="main">
    <h1>👥 Manage Clients</h1>
    <table>
      <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th>
        
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo htmlspecialchars($row['first_name'].' '.$row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td>
              <button class="edit-btn" onclick="window.location.href='edit_client.php?id=<?php echo $row['user_id']; ?>'">Edit</button>
              <button class="delete-btn" onclick="if(confirm('Are you sure?')) window.location.href='delete_client.php?id=<?php echo $row['user_id']; ?>'">Delete</button>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No clients found.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
