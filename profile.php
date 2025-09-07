<?php
session_start();

// Example: Dummy session values (replace with database session data after login)
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name']  = "John Doe";
    $_SESSION['user_email'] = "john@example.com";
    $_SESSION['user_phone'] = "+94 77 123 4567";
}

// Example appointment data (replace with SQL query later)
$recent_appointment = [
    "date" => "2025-09-10",
    "time" => "10:00 AM",
    "service" => "Massage Therapy"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - GreenLife Wellness Center</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family: Arial, sans-serif; }

    body {
        background: #f5f7fa;
        color: #2c3e50;
    }

    header {
        background: #28a745;
        color: white;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header h1 { font-size: 1.5rem; }
    header nav a {
        color: white;
        text-decoration: none;
        margin-left: 15px;
        font-weight: bold;
    }
    header nav a:hover { text-decoration: underline; }

    .container {
        max-width: 1100px;
        margin: 30px auto;
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h1 {
        margin-bottom: 20px;
        color: #28a745;
    }

    .category-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .category-card h2, .category-card h3 {
        margin-bottom: 10px;
        color: #28a745;
    }

    .btn {
        display: inline-block;
        margin: 8px 5px;
        padding: 10px 15px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.3s;
    }

    .btn:hover {
        background: #218838;
    }

    footer {
        text-align: center;
        margin-top: 40px;
        padding: 15px;
        background: #2c3e50;
        color: white;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .container {
            margin: 15px;
            padding: 15px;
        }
    }
  </style>
</head>
<body>

<header>
    <h1>🌿 GreenLife Client Dashboard</h1>
    <nav>
        <a href="client_dashboard.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="appointment.php">Appointments</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>
  
<div class="container">
    <!-- Client Welcome -->
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

    <!-- Personal Information Card -->
    <div class="category-card">
      <h2>Personal Information</h2>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
      <p><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['user_phone']); ?></p>
      <a href="update_profile.php" class="btn">Update Profile</a>
      <a href="change_password.php" class="btn">Change Password</a>
    </div>

    <!-- Recent Appointment Card -->
    <div class="category-card">
      <h2>Recent Appointment</h2>
      <?php if ($recent_appointment): ?>
        <p><strong>Date:</strong> <?php echo $recent_appointment['date']; ?></p>
        <p><strong>Time:</strong> <?php echo $recent_appointment['time']; ?></p>
        <p><strong>Service:</strong> <?php echo $recent_appointment['service']; ?></p>
      <?php else: ?>
        <p>No appointments yet.</p>
      <?php endif; ?>
      <a href="book_appointment.php" class="btn">Book Appointment</a>
    </div>

    <!-- Quick Actions -->
    <div class="category-card">
      <h2>Quick Actions</h2>
      <div class="categories">
        <div class="category-card">
          <h3>📅 Book Appointment</h3>
        </div>
        <div class="category-card">
          <h3>💆 Browse Services</h3>
        </div>
        <div class="category-card">
          <h3>📞 Contact Us</h3>
        </div>
      </div>
    </div>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> GreenLife Wellness Center. All rights reserved.
</footer>

</body>
</html>
