<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - GreenLife Wellness</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; display: flex; min-height: 100vh; background: #ecf0f1; }
    .sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 20px 0; flex-shrink: 0; }
    .sidebar h2 { text-align: center; margin-bottom: 20px; font-size: 18px; }
    .sidebar a { display: block; color: #fff; padding: 12px 20px; text-decoration: none; transition: background 0.3s; }
    .sidebar a:hover { background: #34495e; }
    .main { flex: 1; padding: 30px; }
    .welcome { font-size: 20px; font-weight: bold; margin-bottom: 20px; }

    /* Cards */
    .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .card h3 { margin-bottom: 10px; font-size: 16px; color: #2c3e50; }

    @media(max-width: 768px){ body{flex-direction: column;} .sidebar{width:100%;display:flex;overflow-x:auto;} .sidebar a{flex:1;text-align:center;} }
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
    <div class="welcome">👋 Welcome, Admin!</div>
    <div class="cards">
      <div class="card"><h3>👥 Clients</h3><p>Manage all registered clients.</p></div>
      <div class="card"><h3>📅 Appointments</h3><p>View upcoming client bookings.</p></div>
      <div class="card"><h3>📨 Inquiries</h3><p>Check and respond to inquiries.</p></div>
      <div class="card"><h3>📊 Reports</h3><p>See activity and system reports.</p></div>
    </div>
  </div>
</body>
</html>
