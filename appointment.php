<?php
session_start();

// Example user session
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "John Doe";
    $_SESSION['user_email'] = "john@example.com";
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $notes = $_POST['notes'];

    // Save booking to DB (later connect with MySQL)
    // For now just simulate success
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book a Service - GreenLife</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f7f9;
    }
    .container {
      width: 100%;
      max-width: 600px;
      margin: 60px auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #1d3557;
      margin-bottom: 20px;
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
    button {
      width: 100%;
      padding: 12px;
      background: #2a9d8f;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
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

<div class="container">
  <h2>Book a Service</h2>

  <?php if (!empty($success)) { ?>
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

</body>
</html>
