<?php
session_start();

// Dummy user session data (replace with DB later)
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "John Doe";
    $_SESSION['user_email'] = "john@example.com";
}

// Dummy appointments data (replace with DB query later)
$appointments = [
    ["date" => "12th Sept", "time" => "10:00 AM", "doctor" => "Dr. Smith", "status" => "Confirmed"],
    ["date" => "20th Sept", "time" => "02:00 PM", "doctor" => "Dr. Lee", "status" => "Pending"]
];

// Handle booking form submission
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    // Save booking to DB later...
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GreenLife Wellness Center</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f7f9;
    }
    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0; left: 0;
      width: 250px; height: 100%;
      background: #1d3557;
      color: white;
      padding-top: 20px;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #a8dadc;
    }
    .sidebar a {
      display: block;
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      transition: 0.3s;
    }
    .sidebar a:hover {
      background: #457b9d;
    }
    /* Main */
    .main {
      margin-left: 220px;
      padding: 20px;
    }
    .section {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .section h3 {
      margin-bottom: 15px;
      color: #1d3557;
    }
    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background: #2a9d8f;
      color: white;
    }
    .btn-cancel {
      background: #e63946;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 5px;
      cursor: pointer;
    }
    /* Services */
    .services {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .card {
      background: #f9f9f9;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      transition: 0.3s;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card i {
      font-size: 40px;
      color: #2a9d8f;
      margin-bottom: 15px;
    }
    .card h4 {
      margin-bottom: 10px;
      color: #1d3557;
    }
    .price {
      font-weight: bold;
      margin-bottom: 10px;
      color: #2a9d8f;
    }
    .btn-book {
      background: #2a9d8f;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .btn-book:hover {
      background: #21867a;
    }
    /* Booking form */
    .form-box {
      max-width: 600px;
      margin: 0 auto;
    }
    label {
      font-weight: bold;
      display: block;
      margin: 12px 0 5px;
      color: #333;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 15px;
      font-size: 14px;
    }
    button[type=submit] {
      width: 100%;
      padding: 12px;
      background: #2a9d8f;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    button[type=submit]:hover {
      background: #21867a;
    }
    .success {
      background: #d4edda;
      color: #155724;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Client Dashboard <br> GreenLife Wellness</h2>
    <a href="client_dashboard.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="book_appointment.php" class="active">Appointments</a>
    <a href="clent_contact.php">Contact</a>
    <a href="inquiry.php">Inquiries</a>
    <a href="logout.php">Log Out</a>
  </div>

<div class="main">

  <!-- Appointments -->
  <div class="section">
    <h3>📅 My Appointments</h3>
    <table>
      <tr>
        <th>Date</th><th>Time</th><th>Doctor</th><th>Status</th><th>Action</th>
      </tr>
      <?php foreach ($appointments as $appt) { ?>
      <tr>
        <td><?= $appt['date'] ?></td>
        <td><?= $appt['time'] ?></td>
        <td><?= $appt['doctor'] ?></td>
        <td><?= $appt['status'] ?></td>
        <td><button class="btn-cancel">Cancel</button></td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <!-- Services -->
  <div class="section">
    <h3>🌿 Our Services</h3>
    <div class="services">
      <div class="card">
        <i>🌱</i>
        <h4>Ayurvedic Therapy</h4>
        <p>Restore body balance with herbal oils, massages & detox.</p>
        <div class="price">From Rs. 5,000</div>
        <a href="#booking" class="btn-book">Book Now</a>
      </div>
      <div class="card">
        <i>🧘</i>
        <h4>Yoga & Meditation</h4>
        <p>Improve flexibility & reduce stress with calming sessions.</p>
        <div class="price">From Rs. 3,000</div>
        <a href="#booking" class="btn-book">Book Now</a>
      </div>
      <div class="card">
        <i>🍎</i>
        <h4>Nutrition Consultation</h4>
        <p>Get custom meal plans & expert guidance for wellness.</p>
        <div class="price">From Rs. 4,500</div>
        <a href="#booking" class="btn-book">Book Now</a>
      </div>
      <div class="card">
        <i>🏋️</i>
        <h4>Physiotherapy</h4>
        <p>Improve mobility, relieve pain & recover faster.</p>
        <div class="price">From Rs. 6,000</div>
        <a href="#booking" class="btn-book">Book Now</a>
      </div>
      <div class="card">
        <i>💆</i>
        <h4>Massage Therapy</h4>
        <p>Relax & refresh with stress-relieving massage therapy.</p>
        <div class="price">From Rs. 4,000</div>
        <a href="#booking" class="btn-book">Book Now</a>
      </div>
    </div>
  </div>

  <!-- Booking Form -->
  <div class="section" id="booking">
    <h3>📝 Book a Service</h3>
    <div class="form-box">
      <?php if ($success) { ?>
        <div class="success">✅ Your booking has been submitted successfully!</div>
      <?php } ?>
      <form method="POST">
        <label for="service">Choose a Service</label>
        <select name="service" id="service" required>
          <option value="">-- Select --</option>
          <option value="Ayurvedic Therapy">Ayurvedic Therapy</option>
          <option value="Yoga & Meditation">Yoga & Meditation</option>
          <option value="Nutrition Consultation">Nutrition Consultation</option>
          <option value="Physiotherapy">Physiotherapy</option>
          <option value="Massage Therapy">Massage Therapy</option>
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
