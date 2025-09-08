<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages - Admin</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:Arial,sans-serif;display:flex;min-height:100vh;background:#ecf0f1;}
    .sidebar{width:220px;background:#2c3e50;color:#fff;padding:20px 0;flex-shrink:0;}
    .sidebar h2{text-align:center;margin-bottom:20px;font-size:18px;}
    .sidebar a{display:block;color:#fff;padding:12px 20px;text-decoration:none;transition:background 0.3s;}
    .sidebar a:hover{background:#34495e;}
    .main{flex:1;padding:30px;}
    h1{margin-bottom:20px;color:#2c3e50;}
    .message-box{background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);margin-bottom:15px;}
    .message-box h3{margin-bottom:10px;color:#2c3e50;}
    .message-box p{margin-bottom:5px;}
    .message-box small{color:#7f8c8d;}
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
    <h1>📩 Messages</h1>
    
    <div class="message-box">
      <h3>From: John Doe</h3>
      <p>Hello, I’d like to confirm my appointment for tomorrow.</p>
      <small>Received: 07-Sept-2025 11:30 AM</small>
    </div>

    <div class="message-box">
      <h3>From: Jane Smith</h3>
      <p>Can you please share available slots next week?</p>
      <small>Received: 08-Sept-2025 9:15 AM</small>
    </div>

  </div>
</body>
</html>
