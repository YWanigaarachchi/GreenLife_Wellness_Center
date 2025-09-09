<?php
// Database connection settings
$host = "localhost";
$user = "root";
$password = "#Dell123";
$dbname = "life1";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_errno) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

// Set charset to avoid encoding issues
$conn->set_charset("utf8mb4");
?>
