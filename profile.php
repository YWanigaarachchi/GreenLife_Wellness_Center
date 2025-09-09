<?php
session_start();

// Example session data (replace with real login session later)
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
  <title>Profile - GreenLife Wellness</title>
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

    /* Main Content */
    .main {
      flex: 1;
      padding: 20px;
    }

    /* Profile Card */
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      max-width: 500px;
      margin: auto;
    }
    .card h3 {
      margin-bottom: 15px;
      color: #2c3e50;
    }
    label {
      display: block;
      margin: 8px 0 5px;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      padding: 10px 15px;
      background: #27ae60;
      border: none;
      border-radius: 5px;
      color: #fff;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #219150;
    }

    /* Mobile */
    @media(max-width: 768px) {
      body { flex-direction: column; }
      .sidebar { width: 100%; display: flex; overflow-x: auto; }
      .sidebar a { flex: 1; text-align: center; }
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

  <!-- Main Content -->
  <div class="main">
    <div class="card">
      <h3>👤 Profile Information</h3>
      <form method="post" action="update_profile.php">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

        <button type="submit">Update Profile</button>
      </form>
    </div>
  </div>

</body>
</html>
