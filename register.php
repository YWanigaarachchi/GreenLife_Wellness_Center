<?php
// ENABLE ERROR REPORTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CONNECT TO DATABASE
include("db.php"); // Make sure this sets $conn = new mysqli(...);

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

    if ($password !== $confirm) {
        $message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // ✅ Check if email or username already exists
        $check_sql = "SELECT user_id FROM users WHERE email = ? OR username = ?";
        if ($stmt = $conn->prepare($check_sql)) {
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $check_result = $stmt->get_result();

            if ($check_result && $check_result->num_rows > 0) {
                $message = "Email or username already exists!";
            } else {
                // ✅ Insert new user
                $insert_sql = "INSERT INTO users 
                    (first_name, last_name, username, email, phone, password, role) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

                if ($stmt = $conn->prepare($insert_sql)) {
                    $stmt->bind_param(
                        "sssssss", 
                        $first_name, 
                        $last_name, 
                        $username, 
                        $email, 
                        $phone, 
                        $hashed_password, 
                        $default_role
                    );

                    if ($stmt->execute()) {
                        $message = "✅ Registration successful!";
                    } else {
                        $message = "❌ Something went wrong: " . $stmt->error;
                    }
                } else {
                    $message = "❌ Prepare failed: " . $conn->error;
                }
            }
            $stmt->close();
        } else {
            $message = "❌ Database error: " . $conn->error;
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

body, html { height:100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

.register-wrapper {
    display: flex;
    width: 100%;
    height: 100vh;
}

.register-left {
    flex: 1.5;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f8f9fa;
    padding: 40px;
}

.register-container {
    background: #ffffff;
    padding: 50px 40px;
    border-radius: 20px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

.register-container h2 {
    margin-bottom: 25px;
    text-align: center;
    color: #2c7a2c;
    font-size: 2.2rem;
    font-weight: 700;
}

.register-container input {
    width: 100%;
    padding: 14px 16px;
    margin: 10px 0;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.register-container input:focus {
    outline: none;
    border-color: #2c7a2c;
}

.register-container button {
    width: 100%;
    padding: 14px;
    background: #2c7a2c;
    border: none;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 15px;
}

.register-container button:hover {
    background: #4a9d4a;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(44, 122, 44, 0.3);
}

.message {
    text-align: center;
    margin-bottom: 15px;
    color: #dc3545;
    background: #ffe6e6;
    padding: 10px;
    border-radius: 8px;
}

.register-link {
    margin-top: 25px;
    text-align: center;
    font-size: 0.95rem;
    color: #666;
}

.register-link a {
    color: #2c7a2c;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.register-link a:hover {
    color: #4a9d4a;
}

.register-right {
    flex: 1;
    background: linear-gradient(135deg, rgba(44, 122, 44, 0.4), rgba(74, 157, 74, 0.4)), url('images/about_page.png') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    text-align: center;
    box-shadow: inset 0 0 50px rgba(0,0,0,0.2);
}

.register-right h1 {
    font-size: 2.5rem;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

footer {
    display: none;
}

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
