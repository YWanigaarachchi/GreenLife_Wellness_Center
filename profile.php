<?php
session_start();

// Example: You should replace this with real database user data
// Assume user logged in and session contains their name and ID
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "John Doe"; // Dummy data
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
    <link rel="stylesheet" href="styles.css">

</head>
<body>
  <!-- Header -->
  <header class="site-header">
    <nav class="navbar container">
      <div class="navbar-brand">
        <a href="index.html">🌿 GreenLife Wellness</a>
      </div>
      
      <ul class="navbar-nav" id="navbar-nav">
        <li><a href="index.html" class="nav-link">Home</a></li>
        <li><a href="services.html" class="nav-link">Services</a></li>
        <li><a href="about.html" class="nav-link">About</a></li>
        <li><a href="therapists.html" class="nav-link">Therapists</a></li>
        <li><a href="contact.html" class="nav-link">Contact</a></li>
        <li><a href="profile.php" class="nav-link active">Profile</a></li>
      </ul>
      
      <div class="navbar-actions">
        <a href="logout.php" class="btn btn-primary">Log Out</a>
      </div>
    </nav>
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
  </header>
      <br><br><br><br><br><br><br>    <br><br><br>
  <div class="container">

    <!-- Personal Information Card -->
    <div class="category-card">
      <h2>Personal Information</h2>
      <p><strong>Name:</strong> <?php echo $_SESSION['user_name']; ?></p>
      <p><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
      <p><strong>Phone:</strong> <?php echo $_SESSION['user_phone']; ?></p>
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
      <a href="book_appointment.php" class="btn">Book Your First Appointment</a>
    </div>

    <!-- Quick Actions Card -->
    <div class="">
      <h2>Quick Actions</h2>
      
  <section class="services-preview container" href="services.php">
    <div class="categories">
      <div class="category-card">
        <h3>📅 Book Appointment</h3>
      </div>

      <div class="category-card" href="services.php">
        <h3>💆 Browse Services</h3>
      </div>

      <div class="category-card" href="Contact.html">
        <h3>📞 Contact Us/h3>
      </div>
    </div>
  </section>
    </div>
  </div>
</body>
</html>
