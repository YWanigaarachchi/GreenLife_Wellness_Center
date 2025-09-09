<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inquiries - GreenLife Wellness</title>
  <style>
    /* Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
      background: #ecf0f1;
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

    /* Main */
    .main {
      flex: 1;
      padding: 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    /* Card */
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card h3 {
      margin-bottom: 15px;
      color: #2c3e50;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }
    th {
      background: #8e44ad;
      color: #fff;
    }

    /* Mobile */
    @media(max-width: 768px) {
      body { flex-direction: column; }
      .sidebar { width: 100%; display: flex; overflow-x: auto; }
      .sidebar a { flex: 1; text-align: center; }
      .main { grid-template-columns: 1fr; }
      table { font-size: 14px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Client Dashboard <br> GreenLife Wellness</h2>
    <a href="client_dashboard.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="book_appointment.php">Appointments</a>
    <a href="clent_contact.php">Contact</a>
    <a href="inquiry.php"> Inquiries</a>
    <a href="logout.php">Log Out</a>
  </div>

  <!-- Main -->
  <div class="main">
    
    <!-- My Inquiries -->
    <div class="card">
      <h3>📩 My Inquiries</h3>
      <table>
        <tr>
          <th>Date</th>
          <th>Subject</th>
          <th>Status</th>
        </tr>
        <tr>
          <td>05 Sept</td>
          <td>About membership</td>
          <td>Answered</td>
        </tr>
        <tr>
          <td>07 Sept</td>
          <td>Billing issue</td>
          <td>Pending</td>
        </tr>
      </table>
    </div>

    <!-- New Inquiry -->
    <div class="card">
      <h3>➕ New Inquiry</h3>
      <form action="save_inquiry.php" method="POST">
        <label>Subject:</label><br>
        <input type="text" name="subject" required style="width:100%; padding:8px; margin:8px 0;"><br>
        
        <label>Message:</label><br>
        <textarea name="message" rows="5" required style="width:100%; padding:8px; margin:8px 0;"></textarea><br>
        
        <button type="submit" style="background:#8e44ad; color:#fff; padding:10px 15px; border:none; border-radius:5px; cursor:pointer;">
          Submit Inquiry
        </button>
      </form>
    </div>

  </div>

</body>
</html>
