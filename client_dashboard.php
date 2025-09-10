<?php
session_start();

// Example session data (remove after connecting with login)
$_SESSION['user_name'] = "John Doe";
$_SESSION['user_email'] = "johndoe@email.com";
$_SESSION['user_phone'] = "0712345678";

$name  = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$phone = $_SESSION['user_phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Dashboard - GreenLife Wellness</title>
  <style>
    /* Basic Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; display: flex; min-height: 100vh; flex-direction: column; }

    /* Sidebar + Content wrapper */
    .wrapper {
      display: flex;
      flex: 1;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      background: #2c3e50;
      color: #fff;
      padding: 20px 0;
      flex-shrink: 0;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 18px;
    }
    .sidebar a {
      display: block;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background: #34495e;
    }

    /* Main Content */
    .main {
      flex: 1;
      padding: 20px;
      background: #ecf0f1;
    }
    .welcome {
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: bold;
    }

    /* Cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .card {
      background: #fff;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card h3 {
      margin-bottom: 10px;
      font-size: 16px;
      color: #2c3e50;
    }

    /* Footer */
    .footer {
      background: #2c3e50;
      color: #fff;
      text-align: center;
      padding: 10px 0;
    }
    .footer-bottom p {
      font-size: 14px;
    }

    /* Mobile */
    @media(max-width: 768px) {
      .wrapper { flex-direction: column; }
      .sidebar { width: 100%; display: flex; overflow-x: auto; }
      .sidebar a { flex: 1; text-align: center; }
    }
  </style>
</head>
<body>

  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
      <h2>Client Dashboard <br> GreenLife Wellness</h2>
      <a href="client_dashboard.php">🏠 Home</a>
      <a href="profile.php">👤 Profile</a>
      <a href="book_appointment.php">📅 Appointments</a>
      <a href="inquiry.php">💬 Inquiries</a>
      <a href="logout.php">🚪 Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="main">
      <div class="welcome">Welcome, Client Dashboard </div>

      <div class="cards">
        <div class="card">
          <h3>🔔 Notifications</h3>
          <p>You have 2 new messages.</p>
        </div>

        <div class="card">
          <h3>📅 Upcoming Appointments</h3>
          <p>Next appointment: 12th Sept, 10:00 AM</p>
        </div>

        <div class="card">
          <h3>💡 Wellness Tips</h3>
          <p>Drink at least 8 glasses of water daily.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== Footer Section ===== -->
  <footer class="footer">
    <div class="footer-bottom">
      <p>© 2025 GreenLife Wellness Center | All Rights Reserved</p>
    </div>
  </footer>

</body>
</html>
