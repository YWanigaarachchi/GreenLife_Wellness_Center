<?php 
session_start();
include("db.php"); // DB connection

// Fetch all members
$users = [];
$sql = "SELECT user_id, first_name, last_name, email, phone, role FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result) {
  while($row = $result->fetch_assoc()){
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
    .card-container{display:flex;gap:20px;margin:30px 0;flex-wrap:wrap;}
    .card{flex:1;min-width:220px;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);text-align:center;transition:transform 0.2s;}
    .card:hover{transform:translateY(-5px);}
    .card h3{margin-bottom:15px;color:#2c3e50;}
    .card button{padding:10px 20px;background:#34495e;color:#fff;border:none;border-radius:5px;cursor:pointer;transition:background 0.3s;}
    .card button:hover{background:#2c3e50;}
    /* Modal */
    .modal{display:none;position:fixed;z-index:999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;}
    .modal-content{background:#fff;padding:25px;border-radius:8px;width:400px;max-width:90%;box-shadow:0 2px 6px rgba(0,0,0,0.2);}
    .modal-content h2{margin-bottom:15px;color:#2c3e50;}
    .modal-content label{display:block;margin-top:10px;font-size:14px;color:#2c3e50;}
    .modal-content input{width:100%;padding:8px;margin-top:5px;border:1px solid #ccc;border-radius:4px;}
    .modal-content button{margin-top:15px;padding:10px 15px;border:none;border-radius:5px;cursor:pointer;}
    .close-btn{background:#e74c3c;color:#fff;float:right;}
    .save-btn{background:#27ae60;color:#fff;}
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

    <!-- Add New Members -->
    <h2>➕ Add New Members</h2>
    <div class="card-container">
      <div class="card">
        <h3>New Admin</h3>
        <button onclick="openModal('adminModal')">Add Admin</button>
      </div>
      <div class="card">
        <h3>New Client</h3>
        <button onclick="openModal('clientModal')">Add Client</button>
      </div>
      <div class="card">
        <h3>New Therapist</h3>
        <button onclick="openModal('therapistModal')">Add Therapist</button>
      </div>
    </div>

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
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <!-- Admin Modal -->
  <div class="modal" id="adminModal">
    <div class="modal-content">
      <button class="close-btn" onclick="closeModal('adminModal')">X</button>
      <h2>Add New Admin</h2>
      <form action="save_user.php" method="POST">
        <input type="hidden" name="role" value="admin">
        <label>First Name</label><input type="text" name="first_name" required>
        <label>Last Name</label><input type="text" name="last_name" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Phone</label><input type="text" name="phone" required>
        <label>Username</label><input type="text" name="username" required>
        <label>Password</label><input type="password" name="password" required>
        <button type="submit" class="save-btn">Save Admin</button>
      </form>
    </div>
  </div>

  <!-- Client Modal -->
  <div class="modal" id="clientModal">
    <div class="modal-content">
      <button class="close-btn" onclick="closeModal('clientModal')">X</button>
      <h2>Add New Client</h2>
      <form action="save_user.php" method="POST">
        <input type="hidden" name="role" value="client">
        <label>First Name</label><input type="text" name="first_name" required>
        <label>Last Name</label><input type="text" name="last_name" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Phone</label><input type="text" name="phone" required>
        <label>Username</label><input type="text" name="username" required>
        <label>Password</label><input type="password" name="password" required>
        <button type="submit" class="save-btn">Save Client</button>
      </form>
    </div>
  </div>

  <!-- Therapist Modal -->
  <div class="modal" id="therapistModal">
    <div class="modal-content">
      <button class="close-btn" onclick="closeModal('therapistModal')">X</button>
      <h2>Add New Therapist</h2>
      <form action="save_user.php" method="POST">
        <input type="hidden" name="role" value="therapist">
        <label>First Name</label><input type="text" name="first_name" required>
        <label>Last Name</label><input type="text" name="last_name" required>
        <label>Email</label><input type="email" name="email" required>
        <label>Phone</label><input type="text" name="phone" required>
        <label>Username</label><input type="text" name="username" required>
        <label>Password</label><input type="password" name="password" required>
        <button type="submit" class="save-btn">Save Therapist</button>
      </form>
    </div>
  </div>

<script>
  function openModal(id){ document.getElementById(id).style.display = 'flex'; }
  function closeModal(id){ document.getElementById(id).style.display = 'none'; }
</script>
</body>
</html>
