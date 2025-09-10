<?php
include("db.php"); // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);

        // Prevent deleting yourself (optional)
        session_start();
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id) {
            die("❌ You cannot delete your own account while logged in.");
        }

        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Redirect back to dashboard
            header("Location: admin_dashboard.php?msg=deleted");
            exit();
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Method not allowed.";
}
