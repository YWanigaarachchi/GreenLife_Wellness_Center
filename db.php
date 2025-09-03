<?php
$host = "localhost";
$user = "root";
$password = "#Dell123";
$dbname = "greenlife2";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
