<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dashboard-container {
            width: 90%;
            max-width: 1200px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.25);
        }

        .card h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .card a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            display: block;
            padding: 10px;
            border-radius: 8px;
            background: #3498db;
            transition: background 0.3s;
        }

        .card a:hover {
            background: #1abc9c;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <div class="card-grid">
            <div class="card">
                <h3>👥 View All Users</h3>
                <a href="view_users.php">Go</a>
            </div>
            <div class="card">
                <h3>📅 View Appointments</h3>
                <a href="view_appointments.php">Go</a>
            </div>
            <div class="card">
                <h3>📩 View Inquiries</h3>
                <a href="view_inquiries.php">Go</a>
            </div>
            <div class="card">
                <h3>🚪 Logout</h3>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>

