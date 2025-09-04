<?php
// ENABLE ERROR REPORTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CONNECT TO DATABASE
include("db.php"); // Make sure db.php is in the same folder or give correct path

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    // Check if email already exists
    $check_sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $insert_sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if ($stmt->execute()) {
            $message = "✅ Registration successful!";
        } else {
            $message = "❌ Something went wrong: " . $stmt->error;
        }
    }
}
?>

<!-- HTML form to register -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
      <select name="role" required>
    <option value="">Select Role</option>
    <option value="client">Client</option>
    <option value="therapist">Therapist</option>
    <option value="admin">Admin</option>
</select>

        <button type="submit">Register</button>
        <p class="message"><?php echo $message; ?></p>
    </form>
      <p style="text-align: center; margin-top: 20px;">
    <a href="index.html" class="btn">Back to Home</a>
</p>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <footer>
        <div class="container footer-container">
            <p>&copy; 2025 GreenLife Wellness. All rights reserved.</p>
        </div>  
    </footer>
</body>
</html>
