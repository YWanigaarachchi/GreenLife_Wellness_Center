<?php
session_start();
include("db.php"); // DB connection

// Check if user_id is provided
if (!isset($_GET['user_id'])) {
    header("Location: admin_clients.php");
    exit;
}

$user_id = intval($_GET['user_id']);

// Fetch user details
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone, role, username FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("User not found");
}
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];
    $username = trim($_POST['username']);

    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, role=?, username=? WHERE user_id=?");
    $stmt->bind_param("ssssssi", $first_name, $last_name, $email, $phone, $role, $username, $user_id);
    
    if ($stmt->execute()) {
        header("Location: admin_clients.php");
        exit;
    } else {
        $error = "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User</title>
<style>
body{font-family:Arial,sans-serif;background:#ecf0f1;padding:50px;}
form{background:#fff;padding:30px;border-radius:8px;max-width:500px;margin:auto;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
label{display:block;margin-top:10px;}
input, select{width:100%;padding:8px;margin-top:5px;border-radius:4px;border:1px solid #ccc;}
button{margin-top:15px;padding:10px 15px;background:#27ae60;color:#fff;border:none;border-radius:5px;cursor:pointer;}
button:hover{background:#2ecc71;}
.error{color:red;margin-top:10px;}
</style>
</head>
<body>
<h2>Edit User</h2>
<form method="POST">
    <label>First Name</label>
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
    
    <label>Last Name</label>
    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
    
    <label>Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    
    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
    
    <label>Username</label>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    
    <label>Role</label>
    <select name="role" required>
        <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
        <option value="client" <?php if($user['role']=='client') echo 'selected'; ?>>Client</option>
        <option value="therapist" <?php if($user['role']=='therapist') echo 'selected'; ?>>Therapist</option>
    </select>
    
    <button type="submit">Update User</button>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
</form>
</body>
</html>
