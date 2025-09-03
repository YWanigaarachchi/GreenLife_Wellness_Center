<?php
include("db.php");
session_start();

if ($_SESSION['user_role'] !== 'client') {
    header("Location: login.php");
    exit;
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_SESSION['user_id'];
    $message   = $_POST['message'];

    $sql = "INSERT INTO inquiries (client_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $client_id, $message);

    if ($stmt->execute()) {
        $msg = "✅ Inquiry submitted!";
    } else {
        $msg = "❌ Failed to submit inquiry.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Inquiry</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Submit a Question</h2>
    <form method="POST">
        <textarea name="message" placeholder="Your question..." required></textarea>
        <button type="submit">Send</button>
        <?php if (!empty($msg)) echo "<p class='message'>$msg</p>"; ?>
    </form>
</div>
</body>
</html>
