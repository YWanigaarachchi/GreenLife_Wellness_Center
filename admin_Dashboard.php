<?php session_start(); ?>
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
    /* Cards Section */
    .card-container{display:flex;gap:20px;margin:30px 0;flex-wrap:wrap;}
    .card{flex:1;min-width:220px;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);text-align:center;transition:transform 0.2s;}
    .card:hover{transform:translateY(-5px);}
    .card h3{margin-bottom:15px;color:#2c3e50;}
    .card button{padding:10px 20px;background:#34495e;color:#fff;border:none;border-radius:5px;cursor:pointer;transition:background 0.3s;}
    .card button:hover{background:#2c3e50;}
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Admin Panel</h2>
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

    <!-- Add New Members Section -->
    <h2>➕ Add New Members</h2>
    <div class="card-container">
      <div class="card">
        <h3>New Admin</h3>
        <button onclick="window.location.href='add_admin.php'">Add Admin</button>
      </div>
      <div class="card">
        <h3>New Client</h3>
        <button onclick="window.location.href='add_client.php'">Add Client</button>
      </div>
      <div class="card">
        <h3>New Therapist</h3>
        <button onclick="window.location.href='add_therapist.php'">Add Therapist</button>
      </div>
    </div>

    <!-- Existing Clients Table -->
    <table>
      <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th></tr>
      <tr><td>1</td><td>John Doe</td><td>john@email.com</td><td>0712345678</td><td><button>Edit</button> <button>Delete</button></td></tr>
      <tr><td>2</td><td>Jane Smith</td><td>jane@email.com</td><td>0723456789</td><td><button>Edit</button> <button>Delete</button></td></tr>
    </table>
  </div>
</body>
</html>
