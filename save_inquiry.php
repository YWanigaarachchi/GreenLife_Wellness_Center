<?php
session_start();
include("db.php");

//Make sure the user is logged in
//if (!isset($_SESSION['user_id'])) {
//    header("Location: login.php");
//    exit;
//}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (!empty($subject) && !empty($message)) {
        $sql = "INSERT INTO feedback (user_id, subject, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $subject, $message);

        if ($stmt->execute()) {
            // Success → go back to inquiry page
            header("Location: inquiry.php?success=1");
            exit;
        } else {
            echo "❌ Error: " . $stmt->error;
        }
    } else {
        echo "❌ Please fill in all fields.";
    }
}
?>
