<?php
session_start();
include("db.php");

// ✅ Get client ID from URL
if (!isset($_GET['id'])) {
    die("❌ No client ID provided.");
}
$client_id = intval($_GET['id']);

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);

    $sql = "UPDATE users SET first_name=?, last_name=?, email=?, phone=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone, $client_id);

    if ($stmt->execute()) {
        header("Location: admin_clients.php?msg=Client updated successfully");
        exit;
    } else {
        echo "❌ Update failed: " . $conn->error;
    }
}

// ✅ Fetch existing client details
$sql = "SELECT * FROM users WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Client not found.");
}
$client = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Client</title>
  <style>
    body{font-family:Arial,sans-serif;background:#ecf0f1;padding:30px;}
    .form-container{max-width:500px;margin:auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
    h2{margin-bottom:20px;color:#2c3e50;}
    label{display:block;margin-top:10px;}
    input{width:100%;padding:10px;margin-top:5px;border:1px solid #ccc;border-radius:5px;}
    button{margin-top:20px;padding:10px 15px;background:#27ae60;color:#fff;border:none;border-radius:5px;cursor:pointer;}
    button:hover{background:#219150;}
  </style>
</head>
<body>
  <div class="form-container">
    <h2>✏️ Edit Client</h2>
    <form method="post">
      <label>First Name:</label>
      <input type="text" name="first_name" value="<?php echo htmlspecialchars($client['first_name']); ?>" required>

      <label>Last Name:</label>
      <input type="text" name="last_name" value="<?php echo htmlspecialchars($client['last_name']); ?>" required>

      <label>Email:</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>

      <label>Phone:</label>
      <input type="text" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>" required>

      <button type="submit">Update Client</button>
    </form>
  </div>
</body>
</html>
