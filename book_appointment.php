<?php
session_start();

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];

    // Normally you would INSERT into appointments table in SQL
    $message = "<p style='color:green;'>✅ Appointment booked for $service on $date at $time</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Appointment</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f3f9f6; }
    .container {
      max-width: 400px;
      margin: 50px auto;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }
    h2 { color: #2e8b57; text-align: center; }
    label { display:block; margin-top:10px; }
    input, select {
      width: 100%; padding: 10px; margin-top: 5px;
      border: 1px solid #ccc; border-radius: 6px;
    }
    .btn {
      margin-top: 15px; padding: 10px;
      background: #2e8b57; color: white; border: none;
      border-radius: 6px; cursor: pointer; width: 100%;
    }
    .btn:hover { background: #256d45; }
    .message { text-align: center; font-weight: bold; }
    .back { display:block; text-align:center; margin-top:10px; color:#2e8b57; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Book Appointment</h2>
    <?php if ($message) echo "<div class='message'>$message</div>"; ?>
    <form method="POST">
      <label>Date</label>
      <input type="date" name="date" required>
      <label>Time</label>
      <input type="time" name="time" required>
      <label>Service</label>
      <select name="service" required>
        <option value="">-- Select Service --</option>
        <option>Massage Therapy</option>
        <option>Yoga Session</option>
        <option>Nutrition Consultation</option>
        <option>Physiotherapy</option>
      </select>
      <button type="submit" class="btn">Book Now</button>
    </form>
    <a href="profile.php" class="back">⬅ Back to Profile</a>
  </div>
</body>
</html>
