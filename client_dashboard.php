<?php
session_start();

// Check if user is logged in and role is client
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['user_name']; // stored during login
$email = $_SESSION['user_email']; 
$phone = $_SESSION['user_phone']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Client Dashboard - GreenLife Wellness Center</title>
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

    .dashboard {
        max-width: 1100px;
        margin: 30px auto;
        display: grid;
        grid-template-columns: 1fr 3fr;
        gap: 25px;
    }

    .sidebar {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .sidebar h2 {
        margin-bottom: 15px;
        font-size: 1.3rem;
        color: #28a745;
    }

    .sidebar p { margin: 8px 0; }

    .content {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .content h2 {
        margin-bottom: 20px;
        color: #28a745;
    }

    .card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
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
        .dashboard {
            grid-template-columns: 1fr;
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

<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
    </div>

    <!-- Main content -->
    <div class="content">
        <h2>Your Dashboard</h2>

        <div class="card">
            <h3>Upcoming Appointment</h3>
            <p>No upcoming appointments. <a href="#">Book Now</a></p>
        </div>

        <div class="card">
            <h3>Wellness Tips</h3>
            <ul>
                <li>Stay hydrated 💧</li>
                <li>Take regular breaks 🧘</li>
                <li>Eat balanced meals 🥗</li>
            </ul>
        </div>
    </div>
</div>

<footer>
    &copy; 2025 GreenLife Wellness Center. All Rights Reserved.
</footer>

</body>
</html>
