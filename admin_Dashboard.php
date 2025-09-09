<?php
session_start();
include("db.php"); // DB connection

// Fetch all users
$users = [];
$sql = "SELECT user_id, first_name, last_name, email, phone, role FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Manage Members</title>
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
    .btn{padding:5px 12px;border:none;border-radius:4px;cursor:pointer;}
    .edit-btn{background:#27ae60;color:#fff;}
    .edit-btn:hover{background:#2ecc71;}
    .delete-btn{background:#e74c3c;color:#fff;}
    .delete-btn:hover{background:#c0392b;}
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
    <h1>👥 Manage Members</h1>

    <!-- Members Table -->
    <table>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Action</th></tr>
      <?php foreach($users as $u): ?>
        <tr>
          <td><?php echo $u['user_id']; ?></td>
          <td><?php echo htmlspecialchars($u['first_name']." ".$u['last_name']); ?></td>
          <td><?php echo htmlspecialchars($u['email']); ?></td>
          <td><?php echo htmlspecialchars($u['phone']); ?></td>
          <td><?php echo ucfirst($u['role']); ?></td>
          <td>
            <form style="display:inline-block;" action="edit_user.php" method="GET">
              <input type="hidden" name="user_id" value="<?php echo $u['user_id']; ?>">
              <button class="btn edit-btn">Edit</button>
            </form>
            <form style="display:inline-block;" action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
              <input type="hidden" name="user_id" value="<?php echo $u['user_id']; ?>">
              <button type="submit" class="btn delete-btn">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
