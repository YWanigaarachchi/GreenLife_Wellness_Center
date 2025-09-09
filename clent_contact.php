<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - GreenLife Wellness</title>
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
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    /* Contact Card */
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 600px;
    }
    .card h3 {
      margin-bottom: 20px;
      color: #2c3e50;
      font-size: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    label {
      display: block;
      margin: 10px 0 6px;
      font-weight: bold;
      color: #333;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    textarea { resize: vertical; }

    button {
      padding: 12px 20px;
      background: #2980b9;
      border: none;
      border-radius: 6px;
      color: #fff;
      font-size: 15px;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #21618c;
    }

    /* Mobile */
    @media(max-width: 768px) {
      body { flex-direction: column; }
      .sidebar { width: 100%; display: flex; overflow-x: auto; }
      .sidebar a { flex: 1; text-align: center; }
      .main { padding: 20px; }
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
    <a href="inquiry.php">Inquiries</a>
    <a href="logout.php">Log Out</a>
  </div>

  <!-- Main -->
  <div class="main">
    <div class="card">
      <h3>📞 Contact Us</h3>
      <form method="post" action="send_message.php">
        <label>Your Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Message</label>
        <textarea name="message" rows="6" required></textarea>

        <button type="submit">Send Message</button>
      </form>
    </div>
  </div>

</body>
</html>
