<?php
session_start();

// Dummy values for now
if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = "John Doe";
    $_SESSION['user_email'] = "john@example.com";
    $_SESSION['user_phone'] = "+94 77 123 4567";
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Update session (replace this with SQL UPDATE later)
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_phone'] = $phone;

    $message = "<p style='color:green;'>✅ Profile updated successfully!</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Profile</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f3f9f6; }
    .container {
      max-width: 400px;
      margin: 50px auto;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }
    h2 { color: #2e8b57; text-align: center; }
    label { display:block; margin-top:10px; }
    input {
      width: 100%; padding: 10px; margin-top: 5px;
      border: 1px solid #ccc; border-radius: 6px;
    }
    .btn {
      margin-top: 15px; padding: 10px;
      background: #2e8b57; color: white; border: none;
      border-radius: 6px; cursor: pointer; width: 100%;
    }
    .btn:hover { background: #256d45; }
    .message { text-align: center; font-weight: bold; }
    .back { display:block; text-align:center; margin-top:10px; color:#2e8b57; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Update Profile</h2>
    <?php if ($message) echo "<div class='message'>$message</div>"; ?>
    <form method="POST">
      <label>Full Name</label>
      <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" required>
      <label>Email</label>
      <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" required>
      <label>Phone</label>
      <input type="text" name="phone" value="<?php echo $_SESSION['user_phone']; ?>" required>
      <button type="submit" class="btn">Save Changes</button>
    </form>
    <a href="profile.php" class="back">⬅ Back to Profile</a>
  </div>
</body>
</html>
