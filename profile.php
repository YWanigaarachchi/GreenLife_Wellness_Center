<?php
session_start();

// Example: Dummy session values (replace with real database session data after login)
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'];
    $_SESSION['user_email'];
    $_SESSION['user_phone'];
}
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
        flex-wrap: wrap;
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

    .card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .card h2 {
        margin-bottom: 15px;
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
        header {
            flex-direction: column;
            align-items: flex-start;
        }
        header nav {
            margin-top: 10px;
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
        <a href="messages.php">Messages</a> <!-- Added Messages -->
        <a href="logout.php">Logout</a>
    </nav>
</header>
  
<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

    <!-- Card 1: Login Details -->
    <div class="card">
      <h2>👤 Client Details</h2>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
      <p><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['user_phone']); ?></p>
    </div>

    <!-- Card 2: Update Profile & Change Password -->
    <div class="card">
      <h2>⚙️ Account Settings</h2>
      <a href="update_profile.php" class="btn">Update Profile</a>
      <a href="change_password.php" class="btn">Change Password</a>
    </div>

    <!-- Card 3: Book Appointment -->
    <div class="card">
      <h2>📅 Book Appointment</h2>
      <p>Schedule your next wellness session with ease.</p>
      <a href="book_appointment.php" class="btn">Book Now</a>
    </div>

    <!-- Card 4: Contact Us -->
    <div class="card">
      <h2>📞 Contact Us</h2>
      <p>If you have any questions, reach out to our support team.</p>
      <a href="contact.php" class="btn">Get in Touch</a>
    </div>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> GreenLife Wellness Center. All rights reserved.
</footer>

</body>
</html>
