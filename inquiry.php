<?php 
session_start();
include("db.php"); 

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Show success message if redirected after submission
$success_message = "";
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "✅ Inquiry submitted successfully!";
}

// Fetch inquiries from DB dynamically
$sql = "SELECT subject, message, created_at FROM feedback WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inquiries - GreenLife Wellness</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
      background: #ecf0f1;
    }
    .sidebar {
      width: 220px;
      background: #2c3e50;
      color: #fff;
      padding: 20px 0;
      flex-shrink: 0;
    }
    .sidebar h2 { text-align: center; margin-bottom: 20px; font-size: 18px; }
    .sidebar a {
      display: block;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover { background: #34495e; }
    .main {
      flex: 1;
      padding: 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card h3 { margin-bottom: 15px; color: #2c3e50; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    th { background: #8e44ad; color: #fff; }
    .success-message {
      background: #28a745;
      color: #fff;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      text-align: center;
    }
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
    <a href="client_dashboard.php">🏠 Home</a>
    <a href="profile.php">👤 Profile</a>
    <a href="book_appointment.php">📅 Appointments</a>
    <a href="inquiry.php">💬 Inquiries</a>
    <a href="logout.php">🚪 Log Out</a>
  </div>

  <div class="main">
    
    <!-- My Inquiries -->
    <div class="card">
      <h3>📩 My Inquiries</h3>
      <?php if ($success_message): ?>
        <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
      <?php endif; ?>
      <table>
        <tr>
          <th>Date</th>
          <th>Subject</th>
          <th>Message</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><?= htmlspecialchars($row['message']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="3">No inquiries yet.</td></tr>
        <?php endif; ?>
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
