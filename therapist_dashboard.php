<!-- therapist_dashboard.php -->
<?php
session_start();
// Example session variable
$therapist_name = "Dr. Alex"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Therapist Dashboard - GreenLife Wellness Center</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f7fa;
    }
    .sidebar {
      height: 100vh;
      background-color: #1f3b57;
      color: white;
      padding: 20px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px 0;
    }
    .sidebar a:hover {
      text-decoration: underline;
    }
    .dashboard-content {
      padding: 30px;
    }
    .card {
      margin-bottom: 20px; /* spacing between stacked cards */
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .card h5 {
      font-weight: 600;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar">
      <h4>Therapist</h4>
      <a href="therapist_dashboard.php">Dashboard</a>
      <a href="logout.php">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 dashboard-content">
      <h4>👋 Welcome, <?php echo $therapist_name; ?>!</h4>

      <!-- Cards stacked vertically -->
      <div class="card p-3">
        <h5>👥 All Appointments & Clients</h5>
        <p>View all scheduled appointments and assigned clients.</p>
      </div>

      <div class="card p-3">
        <h5>🛠 Service Appointments</h5>
        <p>Manage therapy sessions and mark them as completed.</p>
      </div>

      <div class="card p-3">
        <h5>✉ Inquiries</h5>
        <p>Check and respond to client inquiries.</p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>