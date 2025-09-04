<?php
// ENABLE ERROR REPORTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CONNECT TO DATABASE
include("db.php");

$message = "";

// Default role for all registrations
$default_role = "client";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $password   = $_POST['password'];
    $confirm    = $_POST['confirm_password'];

    if($password !== $confirm) {
        $message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email or username already exists
        $check_sql = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = "Email or username already exists!";
        } else {
            $insert_sql = "INSERT INTO users (first_name, last_name, username, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("sssssss", $first_name, $last_name, $username, $email, $phone, $hashed_password, $default_role);
            if ($stmt->execute()) {
                $message = "✅ Registration successful!";
            } else {
                $message = "❌ Something went wrong: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GreenLife Wellness Center - Register</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body, html { height:100%; font-family: 'Segoe UI', sans-serif; }

.register-wrapper {
    display: flex;
    width: 100%;
    height: 100vh;
}

/* Left registration form */
.register-left {
    flex: 1.5;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f4f8f6;
    padding: 40px;
}

.register-container {
    background: #fff;
    padding: 50px 40px;
    border-radius: 15px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.register-container h2 {
    margin-bottom: 25px;
    text-align: center;
    color: #2c3e50;
    font-size: 2rem;
}

.register-container input[type="text"],
.register-container input[type="email"],
.register-container input[type="password"],
.register-container input[type="tel"] {
    width: 100%;
    padding: 14px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
}

.register-container button {
    width: 100%;
    padding: 14px;
    background: #28a745;
    border: none;
    color: white;
    font-size: 1.1rem;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
    margin-top: 10px;
}

.register-container button:hover {
    background: #218838;
}

.message {
    text-align: center;
    margin-bottom: 15px;
    color: red;
}

.register-link {
    margin-top: 20px;
    text-align: center;
    font-size: 0.95rem;
}

.register-link a {
    color: #007bff;
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}

/* Right branding image */
.register-right {
    flex: 1;
    background: url('wellness.jpg') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    text-align: center;
}

.register-right h1 {
    font-size: 2.5rem;
    background: rgba(0,0,0,0.5);
    padding: 20px;
    border-radius: 12px;
}

/* Footer */
footer {
    background: #2c3e50;
    color: #fff;
    padding: 15px 0;
    text-align: center;
}

/* Responsive */
@media (max-width: 900px) {
    .register-wrapper {
        flex-direction: column;
    }
    .register-left, .register-right { height: 50vh; padding: 20px; }
}
</style>
</head>
<body>

<div class="register-wrapper">
    <!-- Left registration form -->
    <div class="register-left">
        <div class="register-container">
            <h2>Register</h2>
            <?php if($message): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
            <div class="register-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
                <p><a href="index.html">Back to Home</a></p>
            </div>
        </div>
    </div>

    <!-- Right branding image -->
    <div class="register-right">
        <h1>🌿 GreenLife Wellness Center</h1>
    </div>
</div>

<footer>
    &copy; 2025 GreenLife Wellness Center. All Rights Reserved.
</footer>

</body>
</html>
