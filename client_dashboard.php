<?php
session_start();

// Example session data (remove after connecting with login)
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "John Doe";
    $_SESSION['user_email'] = "johndoe@email.com";
    $_SESSION['user_phone'] = "0712345678";
}

$name  = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$phone = $_SESSION['user_phone'];

// Extract first name for welcome message
$firstName = explode(' ', trim($name))[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Dashboard - GreenLife Wellness</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #2e8b57;
      --primary-dark: #246b44;
      --secondary: #e6f9ed;
      --accent: #1abc9c;
      --bg-color: #f4f7f6;
      --sidebar-bg: #ffffff;
      --text-dark: #2c3e50;
      --text-muted: #7f8c8d;
      --danger: #e74c3c;
      --warning: #f59e0b;
      --info: #3b82f6;
      --white: #ffffff;
      --border: #eaedf1;
      --shadow: 0 4px 6px rgba(0,0,0,0.05);
      --shadow-hover: 0 10px 15px rgba(0,0,0,0.1);
      --transition: all 0.3s ease;
      --radius: 12px;
    }

    * { margin:0; padding:0; box-sizing:border-box; font-family: 'Inter', sans-serif; }
    
    body { background-color: var(--bg-color); color: var(--text-dark); display: flex; min-height: 100vh; overflow-x: hidden; }
    
    /* Sidebar */
    .sidebar { width: 260px; background: var(--sidebar-bg); border-right: 1px solid var(--border); padding: 30px 20px; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100; transition: var(--transition); box-shadow: var(--shadow); }
    .sidebar-header { text-align: center; margin-bottom: 40px; }
    .sidebar-header h2 { font-size: 24px; color: var(--primary); font-weight: 700; letter-spacing: 0.5px; }
    .sidebar-header h2 span { color: var(--text-dark); }
    
    .nav-links { list-style: none; flex: 1; }
    .nav-links li { margin-bottom: 10px; }
    .nav-links a { display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: var(--text-muted); font-weight: 500; border-radius: 8px; transition: var(--transition); }
    .nav-links a i { margin-right: 15px; font-size: 18px; width: 20px; text-align: center; }
    .nav-links a:hover, .nav-links a.active { background: var(--secondary); color: var(--primary); }
    
    .logout-btn { background: #fee2e2; color: var(--danger); margin-top: auto; }
    .logout-btn:hover { background: var(--danger); color: var(--white) !important; }

    /* Main Content Wrapper */
    .main-wrapper { flex: 1; margin-left: 260px; display: flex; flex-direction: column; min-height: 100vh; }
    .main-content { flex: 1; padding: 40px; }
    
    /* Top Header */
    .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
    .top-header h1 { font-size: 28px; font-weight: 700; color: var(--text-dark); }
    .user-profile { display: flex; align-items: center; gap: 15px; background: var(--white); padding: 8px 15px; border-radius: 30px; box-shadow: var(--shadow); border: 1px solid var(--border); }
    .user-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    .user-profile .info span { display: block; font-size: 14px; font-weight: 600; }
    .user-profile .info small { color: var(--text-muted); font-size: 12px; }

    /* Welcome Banner */
    .welcome-banner { background: linear-gradient(135deg, var(--primary) 0%, #1abc9c 100%); border-radius: var(--radius); padding: 30px; color: var(--white); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 10px 20px rgba(46, 139, 87, 0.2); }
    .banner-text h2 { font-size: 24px; margin-bottom: 10px; font-weight: 600; }
    .banner-text p { font-size: 15px; opacity: 0.9; max-width: 500px; line-height: 1.5; }
    .banner-img { font-size: 60px; opacity: 0.8; }

    /* Section Title */
    .section-title { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

    /* Cards Grid */
    .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin-bottom: 40px; }
    .card { background: var(--white); padding: 25px; border-radius: var(--radius); box-shadow: var(--shadow); transition: var(--transition); border: 1px solid var(--border); position: relative; overflow: hidden; display: flex; flex-direction: column; }
    .card:hover { transform: translateY(-5px); box-shadow: var(--shadow-hover); }
    
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 15px; }
    .card-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    
    .card h3 { font-size: 16px; font-weight: 600; color: var(--text-dark); margin: 0; }
    .card-body { flex: 1; }
    .card-body p { color: var(--text-muted); font-size: 14px; line-height: 1.6; }
    .card-body .highlight { font-weight: 600; color: var(--text-dark); display: block; margin-top: 5px; font-size: 15px; }
    
    .card-footer { margin-top: 20px; }
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 14px; text-decoration: none; transition: var(--transition); width: 100%; box-sizing: border-box; }
    
    /* Card Variants */
    .card-notifications { border-top: 4px solid var(--info); }
    .card-notifications .card-icon { background: #eff6ff; color: var(--info); }
    .card-notifications .btn { background: #eff6ff; color: var(--info); }
    .card-notifications .btn:hover { background: var(--info); color: var(--white); }

    .card-appointments { border-top: 4px solid var(--primary); }
    .card-appointments .card-icon { background: var(--secondary); color: var(--primary); }
    .card-appointments .btn { background: var(--primary); color: var(--white); }
    .card-appointments .btn:hover { background: var(--primary-dark); }

    .card-tips { border-top: 4px solid var(--warning); }
    .card-tips .card-icon { background: #fef3c7; color: var(--warning); }
    .card-tips .btn { background: #fef3c7; color: #d97706; }
    .card-tips .btn:hover { background: var(--warning); color: var(--white); }

    /* Footer */
    .dashboard-footer { background: var(--white); text-align: center; padding: 20px; border-top: 1px solid var(--border); color: var(--text-muted); font-size: 14px; }
    
    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar { width: 80px; padding: 20px 10px; }
      .sidebar-header h2 span { display: none; }
      .sidebar-header h2 { font-size: 14px; }
      .nav-links a span { display: none; }
      .nav-links a i { margin: 0; font-size: 20px; }
      .main-wrapper { margin-left: 80px; }
    }
    @media (max-width: 768px) {
      .top-header { flex-direction: column; align-items: flex-start; gap: 20px; }
      .welcome-banner { flex-direction: column; text-align: center; gap: 20px; }
      .banner-img { display: none; }
      .cards-grid { grid-template-columns: 1fr; }
      .main-content { padding: 20px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2><i class="fa-solid fa-leaf"></i> <span>GreenLife</span></h2>
    </div>
    
    <ul class="nav-links">
      <li><a href="client_dashboard.php" class="active"><i class="fa-solid fa-house"></i> <span>Dashboard Home</span></a></li>
      <li><a href="profile.php"><i class="fa-solid fa-id-card"></i> <span>My Profile</span></a></li>
      <li><a href="book_appointment.php"><i class="fa-solid fa-calendar-plus"></i> <span>Book Appointment</span></a></li>
      <li><a href="inquiry.php"><i class="fa-solid fa-comment-dots"></i> <span>My Inquiries</span></a></li>
    </ul>

    <ul class="nav-links" style="flex: 0; margin-top: auto;">
      <li><a href="logout.php" class="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> <span>Log Out</span></a></li>
    </ul>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    
    <main class="main-content">
      
      <!-- Top Header -->
      <div class="top-header">
        <div>
          <h1>Client Dashboard</h1>
          <p style="color: var(--text-muted); margin-top: 5px;">Manage your wellness journey from here.</p>
        </div>
        
        <div class="user-profile">
          <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($name); ?>&background=e6f9ed&color=2e8b57" alt="Profile avatar">
          <div class="info">
            <span><?php echo htmlspecialchars($name); ?></span>
            <small>Client Member</small>
          </div>
        </div>
      </div>

      <!-- Welcome Banner -->
      <div class="welcome-banner">
        <div class="banner-text">
          <h2>Welcome back, <?php echo htmlspecialchars($firstName); ?>! 👋</h2>
          <p>We're glad to see you again. Check your upcoming appointments, explore personalized wellness tips, and continue your journey to a healthier life with GreenLife Wellness Center.</p>
        </div>
        <div class="banner-img">
          <i class="fa-solid fa-seedling"></i>
        </div>
      </div>

      <h3 class="section-title">Overview</h3>
      
      <!-- Cards Grid -->
      <div class="cards-grid">
        
        <!-- Notifications Card -->
        <div class="card card-notifications">
          <div class="card-header">
            <h3>Notifications</h3>
            <div class="card-icon"><i class="fa-regular fa-bell"></i></div>
          </div>
          <div class="card-body">
            <p>You have new messages from your therapist regarding your last session.</p>
            <span class="highlight">2 Unread Messages</span>
          </div>
          <div class="card-footer">
            <a href="inquiry.php" class="btn">View Messages <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>

        <!-- Appointments Card -->
        <div class="card card-appointments">
          <div class="card-header">
            <h3>Upcoming Appointments</h3>
            <div class="card-icon"><i class="fa-regular fa-calendar-check"></i></div>
          </div>
          <div class="card-body">
            <p>Your next scheduled wellness session is coming up soon.</p>
            <span class="highlight">Sept 12th, 10:00 AM</span>
          </div>
          <div class="card-footer">
            <a href="book_appointment.php" class="btn">Manage Appointments <i class="fa-solid fa-calendar-days"></i></a>
          </div>
        </div>

        <!-- Wellness Tips Card -->
        <div class="card card-tips">
          <div class="card-header">
            <h3>Wellness Tips</h3>
            <div class="card-icon"><i class="fa-regular fa-lightbulb"></i></div>
          </div>
          <div class="card-body">
            <p>Daily Tip: Drink at least 8 glasses of water daily to maintain steady energy levels and support your metabolism.</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn">Read More Tips <i class="fa-solid fa-book-open"></i></a>
          </div>
        </div>

      </div>

    </main>

    <!-- Footer -->
    <footer class="dashboard-footer">
      <p>&copy; <?php echo date("Y"); ?> GreenLife Wellness Center. All Rights Reserved.</p>
    </footer>

  </div>

</body>
</html>
