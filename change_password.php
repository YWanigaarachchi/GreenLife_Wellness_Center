<?php
session_start();

// Dummy session values
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "John Doe";
    $_SESSION['user_email'] = "john@example.com";
    $_SESSION['user_phone'] = "+94 77 123 4567";
}

// Example appointment (replace with SQL later)
$recent_appointment = [
    "date" => "2025-09-10",
    "time" => "10:00 AM",
    "service" => "Massage Therapy"
];

// Handle password change request
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $stored_password = "123456"; // Dummy current password
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($current !== $stored_password) {
        $message = "<p style='color:red;'>❌ Current password is incorrect.</p>";
    } elseif ($new !== $confirm) {
        $message = "<p style='color:red;'>❌ New passwords do not match.</p>";
    } elseif (strlen($new) < 6) {
        $message = "<p style='color:red;'>❌ Password must be at least 6 characters long.</p>";
    } else {
        $message = "<p style='color:green;'>✅ Password successfully changed!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - GreenLife Wellness Center</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f9f6;
      margin: 0;
      padding: 0;
    }
    header {
      background: #2e8b57;
      color: white;
      padding: 15px;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }
    .navbar-brand a {
      font-size: 20px;
      font-weight: bold;
      color: white;
      text-decoration: none;
    }
    .navbar-nav {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 15px;
    }
    .nav-link {
      text-decoration: none;
      color: white;
      font-weight: 500;
    }
    .nav-link.active { text-decoration: underline; }
    .container {
      width: 90%;
      max-width: 1000px;
      margin: 30px auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }
    h1 { margin: 10px 0 0; }
    h2 { margin-top: 0; color: #2e8b57; }
    .btn {
      display: inline-block;
      padding: 10px 15px;
      margin: 8px 5px 0 0;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
      color: white;
      background: #2e8b57;
      transition: 0.3s;
      cursor: pointer;
      border: none;
    }
    .btn:hover { background: #256d45; }

    /* Popup Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 12px;
      width: 350px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
    }
    .modal-content h3 { margin-top: 0; color: #2e8b57; }
    .modal-content label { display:block; margin-top:10px; }
    .modal-content input {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .close-btn {
      float: right;
      font-size: 20px;
      cursor: pointer;
      color: #666;
    }
    .message { margin: 10px 0; text-align:center; font-weight: bold; }
  </style>
</head>
<body>

  <div class="container">
    <!-- Personal Information Card -->
    <div class="card">
      <h2>Personal Information</h2>
      <p><strong>Name:</strong> <?php echo $_SESSION['user_name']; ?></p>
      <p><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
      <p><strong>Phone:</strong> <?php echo $_SESSION['user_phone']; ?></p>
      <button class="btn" onclick="openModal()">Change Password</button>
    </div>
    
  <!-- Password Change Modal -->
  <div id="passwordModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h3>Change Password</h3>
      <?php if ($message) echo "<div class='message'>$message</div>"; ?>
      <form method="POST" action="">
        <label>Current Password</label>
        <input type="password" name="current_password" required>
        <label>New Password</label>
        <input type="password" name="new_password" required>
        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" required>
        <button type="submit" name="change_password" class="btn" style="width:100%;">Update Password</button>
      </form>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById('passwordModal').style.display = 'flex';
    }
    function closeModal() {
      document.getElementById('passwordModal').style.display = 'none';
    }
    // Auto open modal if there is a PHP message (after submit)
    <?php if ($message) echo "openModal();"; ?>
  </script>
</body>
</html>
