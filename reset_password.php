<?php
session_start();
include("db.php");

$message = "";
$show_form = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check token validity
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $show_form = true;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];

            if ($password !== $confirm) {
                $message = "Passwords do not match.";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
                $update->bind_param("si", $hashed, $user['id']);
                $update->execute();

                $message = "Password has been reset successfully! <a href='login.php'>Login here</a>";
                $show_form = false;
            }
        }
    } else {
        $message = "Invalid or expired token.";
    }
} else {
    $message = "No token provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password - GreenLife Wellness Center</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body { font-family: Arial, sans-serif; background: #f5f7fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
    .container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
    h2 { color: #28a745; margin-bottom: 20px; }
    input[type="password"] { width: 100%; padding: 12px; margin: 12px 0; border-radius: 8px; border: 1px solid #ccc; }
    input[type="submit"] { padding: 12px; width: 100%; background: #28a745; color: white; border: none; border-radius: 8px; cursor: pointer; }
    input[type="submit"]:hover { background: #218838; }
    .message { margin-top: 15px; color: red; }
    a { color: #007bff; text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h2>Reset Password</h2>
    <?php if ($message) echo "<div class='message'>$message</div>"; ?>
    <?php if ($show_form): ?>
        <form method="POST" action="">
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" value="Reset Password">
        </form>
    <?php endif; ?>
</div>
</body>
</html>
