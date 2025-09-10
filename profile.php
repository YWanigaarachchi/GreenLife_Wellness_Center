<?php
session_start();

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost";    // change if needed
$db   = "life1";    // your database name
$user = "root";         // your MySQL username
$pass = "#Dell123";             // your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged in user ID from session
$user_id = $_SESSION['user_id'];

// Query user details
$sql = "SELECT first_name, last_name, username, email, phone, role, created_at 
        FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - GreenLife Wellness</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      min-height: 100vh;
      background: #f4f7f9;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: linear-gradient(180deg, #2c3e50, #1a252f);
      color: #fff;
      padding: 25px 0;
      flex-shrink: 0;
      box-shadow: 2px 0 8px rgba(0,0,0,0.15);
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 18px;
      line-height: 1.4;
    }
    .sidebar a {
      display: block;
      color: #ddd;
      padding: 14px 25px;
      text-decoration: none;
      transition: background 0.3s, color 0.3s;
      font-size: 15px;
    }
    .sidebar a:hover {
      background: #34495e;
      color: #fff;
    }

    /* Main Content */
    .main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    /* Profile Card */
    .card {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 100%;
      text-align: center;
    }
    .avatar {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      background: #27ae60;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 36px;
      margin: 0 auto 20px;
    }
    .card h3 {
      margin-bottom: 20px;
      color: #2c3e50;
      font-size: 22px;
    }
    .info {
      text-align: left;
      margin-top: 20px;
    }
    .info p {
      margin: 12px 0;
      font-size: 16px;
      color: #333;
    }
    .info span {
      font-weight: bold;
      color: #2c3e50;
      display: inline-block;
      width: 120px;
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
    <a href="client_dashboard.php">🏠 Home</a>
    <a href="profile.php">👤 Profile</a>
    <a href="book_appointment.php">📅 Appointments</a>
    <a href="inquiry.php">💬 Inquiries</a>
    <a href="logout.php">🚪 Log Out</a>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="card">
      <div class="avatar">👤</div>
      <h3>Profile Information</h3>
      <div class="info">
        <p><span>First Name:</span> <?php echo htmlspecialchars($userData['first_name']); ?></p>
        <p><span>Last Name:</span> <?php echo htmlspecialchars($userData['last_name']); ?></p>
        <p><span>Username:</span> <?php echo htmlspecialchars($userData['username']); ?></p>
        <p><span>Email:</span> <?php echo htmlspecialchars($userData['email']); ?></p>
        <p><span>Phone:</span> <?php echo htmlspecialchars($userData['phone']); ?></p>
        <p><span>Role:</span> <?php echo htmlspecialchars($userData['role']); ?></p>
        <p><span>Joined:</span> <?php echo htmlspecialchars($userData['created_at']); ?></p>
        <p><span>Password:</span> ********</p>
      </div>
    </div>
  </div>

</body>
</html>
