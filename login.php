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
        // Fixed: Use correct column name 'user_id'
        $_SESSION['user_id'] = $user['user_id'];
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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
    }

    .login-wrapper {
      display: flex;
      width: 100%;
      height: 100vh;
    }

    .login-left {
      flex: 1;
      background: linear-gradient(135deg, rgba(44, 122, 44, 0.4), rgba(74, 157, 74, 0.4)), url('images/wellness_hero.png') no-repeat center center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-align: center;
      box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.2);
    }

    .login-left h1 {
      font-size: 2.8rem;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      padding: 30px;
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .login-right {
      flex: 1.5;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f8f9fa;
      padding: 40px;
    }

    .login-container {
      background: #ffffff;
      padding: 60px 50px;
      border-radius: 20px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .login-container h2 {
      margin-bottom: 25px;
      text-align: center;
      color: #2c7a2c;
      font-size: 2.2rem;
      font-weight: 700;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 14px 16px;
      margin: 12px 0;
      border: 2px solid #e0e0e0;
      border-radius: 12px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    .login-container input:focus {
      outline: none;
      border-color: #2c7a2c;
    }

    .login-container input[type="submit"] {
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

    .login-container input[type="submit"]:hover {
      background: #4a9d4a;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(44, 122, 44, 0.3);
    }

    .message {
      color: #dc3545;
      background: #ffe6e6;
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      margin-bottom: 15px;
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
    <div class="login-left">
      <h1>🌿 GreenLife Wellness Center</h1>
    </div>
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
          <p><a href="forgot_password.php">Forgot My Password?</a></p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>