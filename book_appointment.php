<?php
session_start();
include("db.php"); // DB connection

// ✅ Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id   = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? "";
$user_email = $_SESSION['user_email'] ?? "";

// ✅ Fetch appointments for this client dynamically
$appointments = [];
$sql = "SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.status, a.notes,
             u.first_name As therapist_name, s.name AS service_name
        FROM appointments a
        JOIN therapists t ON a.therapist_id = t.therapist_id
        JOIN services s ON a.service_id = s.service_id
        JOIN users u ON t.user_id = u.user_id
        WHERE a.client_id = ?
        ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
    $stmt->close();
}

// ✅ Handle booking form submission
$success = false;
$error   = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = intval($_POST['service']);
    $date       = $_POST['date'];
    $time       = $_POST['time'];
    $notes      = $_POST['notes'];

    if ($service_id && $date && $time) {
        // Append seconds to time if needed
        if (strlen($time) == 5) $time .= ":00";

        // Select a random available therapist
        $therapist_sql = "SELECT therapist_id FROM therapists ORDER BY RAND() LIMIT 1";
        $therapist_result = $conn->query($therapist_sql);
        if ($therapist_result->num_rows > 0) {
            $therapist = $therapist_result->fetch_assoc();
            $therapist_id = $therapist['therapist_id'];
        } else {
            $error = "No therapist available at the moment.";
        }

        if (!$error) {
            $insert = $conn->prepare("INSERT INTO appointments 
                (client_id, therapist_id, service_id, appointment_date, appointment_time, status, notes) 
                VALUES (?, ?, ?, ?, ?, 'pending', ?)");
            
            if ($insert) {
                $insert->bind_param("iiisss", $user_id, $therapist_id, $service_id, $date, $time, $notes);
                if ($insert->execute()) {
                    $success = true;
                    header("Location: book_appointment.php?success=1");
                    exit;
                } else {
                    $error = "Insert failed: " . $insert->error;
                }
                $insert->close();
            } else {
                $error = "Prepare failed: " . $conn->error;
            }
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}

// ✅ Fetch all services dynamically
$services = [];
$service_result = $conn->query("SELECT * FROM services");
if ($service_result) {
    while ($row = $service_result->fetch_assoc()) {
        $services[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GreenLife Wellness Center</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background: #f4f7f9; }
    .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100%; background: #1d3557; color: white; padding-top: 20px; }
    .sidebar h2 { text-align: center; margin-bottom: 30px; color: #a8dadc; }
    .sidebar a { display: block; color: white; padding: 12px 20px; text-decoration: none; transition: 0.3s; }
    .sidebar a:hover { background: #457b9d; }
    .main { margin-left: 220px; padding: 20px; }
    .section { background: white; border-radius: 10px; padding: 20px; margin-bottom: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .section h3 { margin-bottom: 15px; color: #1d3557; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
    th { background: #2a9d8f; color: white; }
    .btn-cancel { background: #e63946; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; }
    .services { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    .card { background: #f9f9f9; border-radius: 10px; padding: 20px; text-align: center; transition: 0.3s; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    .card:hover { transform: translateY(-5px); }
    .card h4 { margin-bottom: 10px; color: #1d3557; }
    .price { font-weight: bold; margin-bottom: 10px; color: #2a9d8f; }
    .btn-book { background: #2a9d8f; color: white; padding: 8px 14px; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; }
    .btn-book:hover { background: #21867a; }
    .form-box { max-width: 600px; margin: 0 auto; }
    label { font-weight: bold; display: block; margin: 12px 0 5px; color: #333; }
    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }
    button[type=submit] { width: 100%; padding: 12px; background: #2a9d8f; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; }
    button[type=submit]:hover { background: #21867a; }
    .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 15px; text-align: center; }
    .error { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 15px; text-align: center; }
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

<div class="main">

  <!-- Appointments -->
  <div class="section">
    <h3>📅 My Appointments</h3>
    <table>
      <tr>
        <th>Date</th><th>Time</th><th>Therapist</th><th>Service</th><th>Status</th><th>Action</th>
      </tr>
      <?php if (count($appointments) > 0) { 
        foreach ($appointments as $appt) { ?>
      <tr>
        <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
        <td><?= htmlspecialchars($appt['appointment_time']) ?></td>
        <td><?= htmlspecialchars($appt['therapist_name']) ?></td>
        <td><?= htmlspecialchars($appt['service_name']) ?></td>
        <td><?= ucfirst($appt['status']) ?></td>
        <td>
          <?php if ($appt['status'] == 'pending' || $appt['status'] == 'confirmed') { ?>
            <form method="POST" action="cancel_appointment.php" style="display:inline;">
              <input type="hidden" name="appointment_id" value="<?= $appt['appointment_id'] ?>">
              <button type="submit" class="btn-cancel">Cancel</button>
            </form>
          <?php } ?>
        </td>
      </tr>
      <?php } } else { ?>
        <tr><td colspan="6">No appointments booked yet.</td></tr>
      <?php } ?>
    </table>
  </div>

  <!-- Services -->
  <div class="section">
    <h3>🌿 Our Services</h3>
    <div class="services">
      <?php if (count($services) > 0) {
          foreach ($services as $service) { ?>
              <div class="card">
                <h4><?= htmlspecialchars($service['name']) ?></h4>
                <p><?= htmlspecialchars($service['description']) ?></p>
                <div class="price">From Rs. <?= number_format($service['price'], 0) ?></div>
                <a href="#booking" class="btn-book">Book Now</a>
              </div>
      <?php } } else { echo "<p>No services available at the moment.</p>"; } ?>
    </div>
  </div>

  <!-- Booking Form -->
  <div class="section" id="booking">
    <h3>📝 Book a Service</h3>
    <div class="form-box">
      <?php if ($success) { ?>
        <div class="success">✅ Your booking has been submitted successfully!</div>
      <?php } ?>
      <?php if ($error) { ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php } ?>
      <form method="POST">
        <label for="service">Choose a Service</label>
        <select name="service" id="service" required>
          <option value="">-- Select --</option>
          <?php foreach ($services as $service) {
              echo '<option value="'.$service['service_id'].'">'.htmlspecialchars($service['name']).'</option>';
          } ?>
        </select>

        <label for="date">Select Date</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Select Time</label>
        <input type="time" id="time" name="time" required>

        <label for="notes">Additional Notes</label>
        <textarea id="notes" name="notes" rows="4" placeholder="Any special requests..."></textarea>

        <button type="submit">Confirm Booking</button>
      </form>
    </div>
  </div>

</div>
</body>
</html>
