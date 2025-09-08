<?php
ob_start();
session_start();
include("db.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                switch ($user['role']) {
                    case 'client':
                        header("Location: client_dashboard.php");
                        break;
                    case 'therapist':
                        header("Location: therapist_dashboard.php");
                        break;
                    case 'admin':
                        header("Location: admin_Dashboard.php");
                        break;
                    default:
                        header("Location: login.php");
                        break;
                }
                exit;
            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "No user found with this email.";
        }

        $stmt->close();
    } else {
        $message = "Query preparation failed.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GreenLife Wellness Center - Login</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
    }

    .login-wrapper {
      display: flex;
      width: 100%;
      height: 100vh;
    }

    /* Left side image */
    .login-left {
      flex: 1;
      background: url('wellness.jpg') no-repeat center center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-align: center;
    }
    .login-left h1 {
      font-size: 2.5rem;
      background: rgba(0,0,0,0.5);
      padding: 20px;
      border-radius: 12px;
    }

    /* Right side login */
    .login-right {
      flex: 1.5;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f4f8f6;
      padding: 40px;
    }

    .login-container {
      background: #fff;
      padding: 60px 50px;
      border-radius: 15px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .login-container h2 {
      margin-bottom: 25px;
      text-align: center;
      color: #2c3e50;
      font-size: 2rem;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 14px;
      margin: 12px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    .login-container input[type="submit"] {
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
    }

    .login-container input[type="submit"]:hover {
      background: #218838;
    }

    .message {
      color: red;
      text-align: center;
      margin-bottom: 15px;
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

    /* Responsive */
    @media (max-width: 900px) {
      .login-wrapper {
        flex-direction: column;
      }
      .login-left {
        height: 35vh;
      }
      .login-right {
        height: 65vh;
      }
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    
    <!-- Left branding -->
    <div class="login-left">
      <h1>🌿 GreenLife Wellness Center</h1>
    </div>

    <!-- Right login form -->
    <div class="login-right">
      <div class="login-container">
        <h2>Login</h2>
        <?php if ($message): ?>
          <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
          <input type="email" name="email" placeholder="Enter your email" required>
          <input type="password" name="password" placeholder="Enter your password" required>
          <input type="submit" value="Login">
        </form>
        <div class="register-link">
          <p>Don't have an account? <a href="register.php">Register here</a></p>
          <p><a href="forgot_password.php">Forgot My Password?</a></p> <!-- Added -->
        </div>
      </div>
    </div>
  </div>
</body>
</html>
