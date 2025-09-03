<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_SESSION['user_id'];
    $therapist = $_POST['therapist'];
    $service   = $_POST['service'];
    $date      = $_POST['date'];

    $sql = "INSERT INTO appointments (client_id, therapist, service, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $client_id, $therapist, $service, $date);

    if ($stmt->execute()) {
        $message = "✅ Appointment booked!";
    } else {
        $message = "❌ Failed to book appointment.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Book an Appointment</h2>
    <form method="POST">
        <input type="text" name="therapist" placeholder="Therapist Name" required>

        <!-- Service Dropdown -->
        <select name="service" required>
            <option value="">Select Service</option>
            <option value="Ayurvedic Therapy">Ayurvedic Therapy</option>
            <option value="Yoga & Meditation">Yoga & Meditation</option>
            <option value="Nutrition Consultation">Nutrition Consultation</option>
            <option value="Massage Therapy">Massage Therapy</option>
        </select>

        <input type="date" name="date" required>

        <button type="submit">Book</button>
    </form>

    <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
</div>
</body>
</html>
