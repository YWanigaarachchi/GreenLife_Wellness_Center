<!-- therapist_dashboard.php -->
<?php
session_start();
include("db.php"); // Include your database connection

// Example session variable (replace with session login info)
$therapist_name = "Dr. Alex"; 
$therapist_id = 1; // Replace with the logged-in therapist ID from session

// Fetch all clients
$clients_sql = "SELECT user_id, first_name, last_name, email, phone FROM users WHERE role='client'";
$clients_result = $conn->query($clients_sql);

// Fetch all appointments for this therapist
$appointments_sql = "SELECT a.appointment_id, u.first_name AS client_first, u.last_name AS client_last, 
                     a.appointment_date, a.appointment_time, a.status
                     FROM appointments a
                     JOIN users u ON a.client_id = u.user_id
                     WHERE a.therapist_id = $therapist_id
                     ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$appointments_result = $conn->query($appointments_sql);

// Fetch all inquiries/feedback
$feedback_sql = "SELECT f.feedback_id, u.first_name, u.last_name, f.subject, f.message, f.created_at
                 FROM feedback f
                 JOIN users u ON f.user_id = u.user_id
                 ORDER BY f.created_at DESC";
$feedback_result = $conn->query($feedback_sql);
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
    body { background-color: #f4f7fa; }
    .sidebar { height: 100vh; background-color: #1f3b57; color: white; padding: 20px; }
    .sidebar a { color: white; text-decoration: none; display: block; padding: 10px 0; }
    .sidebar a:hover { text-decoration: underline; }
    .dashboard-content { padding: 30px; }
    .card { margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .card h5 { font-weight: 600; }
    table th, table td { vertical-align: middle !important; }
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
      <h4>👋 Welcome,Therapist Dashboard </h4>

      <!-- All Clients Card -->
      <div class="card p-3">
        <h5>👥 All Clients</h5>
        <?php if ($clients_result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped mt-2">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; while($client = $clients_result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $client['first_name'] . ' ' . $client['last_name']; ?></td>
                  <td><?php echo $client['email']; ?></td>
                  <td><?php echo $client['phone']; ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
          <p>No clients found.</p>
        <?php endif; ?>
      </div>

      <!-- All Appointments Card -->
      <div class="card p-3">
        <h5>🗓 All Appointments</h5>
        <?php if ($appointments_result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped mt-2">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Client</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; while($appt = $appointments_result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $appt['client_first'] . ' ' . $appt['client_last']; ?></td>
                  <td><?php echo $appt['appointment_date']; ?></td>
                  <td><?php echo $appt['appointment_time']; ?></td>
                  <td><?php echo ucfirst($appt['status']); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
          <p>No appointments scheduled.</p>
        <?php endif; ?>
      </div>

      <!-- All Inquiries Card -->
      <div class="card p-3">
        <h5>✉ Client Inquiries</h5>
        <?php if ($feedback_result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped mt-2">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Client</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; while($fb = $feedback_result->fetch_assoc()): ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $fb['first_name'] . ' ' . $fb['last_name']; ?></td>
                  <td><?php echo $fb['subject']; ?></td>
                  <td><?php echo $fb['message']; ?></td>
                  <td><?php echo $fb['created_at']; ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
          <p>No inquiries found.</p>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
