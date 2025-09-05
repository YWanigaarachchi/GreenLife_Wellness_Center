
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
            flex-direction: column;
        }

        /* Navbar */
        nav {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(6px);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            letter-spacing: 1px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #1abc9c;
        }

        /* Dashboard container */
        .dashboard-container {
            flex: 1;
            width: 95%;
            max-width: 1400px;
            margin: 30px auto;
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

        /* Sections */
        .section-title {
            margin: 20px 0 15px;
            font-size: 1.5rem;
            border-left: 5px solid #1abc9c;
            padding-left: 10px;
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
        }

        .card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.25);
        }

        .card h3 {
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .card p {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
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
    <!-- Navbar -->
    <nav>
        <div class="logo">Admin Panel</div>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="view_users.php">Manage Users</a></li>
            <li><a href="manage_services.php">Manage Services</a></li>
            <li><a href="view_appointments.php">Manage Application</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>

    <!-- Dashboard -->
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>

        <!-- Stats Section -->
        <h3 class="section-title">📊 Statistics</h3>
        <div class="card-grid">
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="card">
                <h3>Total Appointments</h3>
                <p><?php echo $total_appointments; ?></p>
            </div>
            <div class="card">
                <h3>Administrators</h3>
                <p><?php echo $total_admins; ?></p>
            </div>
            <div class="card">
                <h3>Pending Appointments</h3>
                <p><?php echo $pending_appointments; ?></p>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <h3 class="section-title">⚡ Quick Actions</h3>
        <div class="card-grid">
            <div class="card">
                <h3>Add New User</h3>
                <a href="add_user.php">Add</a>
            </div>
            <div class="card">
                <h3>Add New Service</h3>
                <a href="add_service.php">Add</a>
            </div>
            <div class="card">
                <h3>Add New Therapist</h3>
                <a href="add_therapist.php">Add</a>
            </div>
        </div>

        <!-- Services Section -->
        <h3 class="section-title">🛠 Services</h3>
        <div class="card-grid">
            <div class="card">
                <h3>View All Appointments</h3>
                <a href="view_appointments.php">View</a>
            </div>
            <div class="card">
                <h3>View All Users</h3>
                <a href="view_users.php">View</a>
            </div>
        </div>
    </div>
</body>
</html>
