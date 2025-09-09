<?php
include("db.php"); // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $password   = $_POST['password'];
    $role       = $_POST['role'];

    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($phone) || empty($password)) {
        die("⚠️ All fields are required.");
    }

    // Check for duplicates
    $check = $conn->prepare("SELECT user_id FROM users WHERE email=? OR username=?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        die("⚠️ Username or Email already exists!");
    }
    $check->close();

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (first_name, last_name, username, email, phone, password, role) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssss", $first_name, $last_name, $username, $email, $phone, $hashedPassword, $role);

        if ($stmt->execute()) {
            header("Location: admin_clients.php?success=1");
            exit;
        } else {
            die("❌ Error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("❌ Error preparing statement: " . $conn->error);
    }
}
$conn->close();
?>
