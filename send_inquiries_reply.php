<?php
session_start();
include("db.php"); // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $feedback_id   = intval($_POST['feedback_id']);
    $client_email  = trim($_POST['client_email']);
    $reply_message = trim($_POST['reply_message']);
    $admin_id      = $_SESSION['user_id'] ?? null; // if admin login system exists

    if (!empty($feedback_id) && !empty($reply_message)) {
        // ✅ Save reply in DB
        $stmt = $conn->prepare("INSERT INTO replies (feedback_id, admin_id, reply_message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $feedback_id, $admin_id, $reply_message);
        $stmt->execute();

        // ✅ Send Email to client
        $subject = "Reply to your inquiry (ID: $feedback_id)";
        $headers = "From: support@yourdomain.com\r\n";
        $headers .= "Reply-To: support@yourdomain.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $mail_sent = mail($client_email, $subject, $reply_message, $headers);

        if ($mail_sent) {
            $_SESSION['success'] = "Reply sent successfully!";
        } else {
            $_SESSION['error'] = "Reply saved, but email could not be sent.";
        }
    } else {
        $_SESSION['error'] = "Missing reply message.";
    }

    header("Location: admin_inquiries.php");
    exit;
} else {
    header("Location: admin_inquiries.php");
    exit;
}
