<?php
session_start();
include("db.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id, user_name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store token and expiry in database
        $update = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE id = ?");
        $update->bind_param("ssi", $token, $expiry, $user['id']);
        $update->execute();

        // Send reset email
        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $body = "Hi ".$user['user_name'].",\n\nClick the link below to reset your password:\n$reset_link\n\nThis link is valid for 1 hour.";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $body, $headers)) {
            $message = "A password reset link has been sent to your email.";
        } else {
            $message = "Failed to send email. Please try again later.";
        }
    } else {
        $message = "No account found with this email.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password - GreenLife Wellness Center</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body { font-family: Arial, sans-serif; background: #f5f7fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
    .container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
    h2 { color: #28a745; margin-bottom: 20px; }
    input[type="email"] { width: 100%; padding: 12px; margin: 12px 0; border-radius: 8px; border: 1px solid #ccc; }
    input[type="submit"] { padding: 12px; width: 100%; background: #28a745; color: white; border: none; border-radius: 8px; cursor: pointer; }
    input[type="submit"]:hover { background: #218838; }
    .message { margin-top: 15px; color: red; }
    a { color: #007bff; text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h2>Forgot Password</h2>
    <?php if ($message) echo "<div class='message'>".htmlspecialchars($message)."</div>"; ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <input type="submit" value="Send Reset Link">
    </form>
    <p><a href="login.php">Back to Login</a></p>
</div>
</body>
</html>
