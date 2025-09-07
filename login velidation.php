<?php
session_start();

// Database connection
$servername = "localhost";   // change if needed
$username   = "root";        // your DB username
$password   = "#Dell123";            // your DB password
$dbname     = "life1";   // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form input
$user = $_POST['username'];
$pass = $_POST['password'];

// Fetch user from DB
$sql = "SELECT * FROM users WHERE email='$user' OR name='$user' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($pass, $row['password'])) {
        
        // Save session details
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['role'] = $row['role'];  // role column must exist in users table

        // Redirect based on role
        if ($row['role'] == 'admin') {
            header("Location: admin_Dashboard.php");
            exit();
        } elseif ($row['role'] == 'therapist') {
            header("Location: therapist_dashboard.php");
            exit();
        } elseif ($row['role'] == 'guest') {
            header("Location: client_dashboard.php");
            exit();
        } else {
            echo "Invalid role assigned!";
        }

    } else {
        echo "Invalid password!";
    }

} else {
    echo "No user found with that username or email!";
}

$conn->close();
?>