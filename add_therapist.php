<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];

    $sql = "INSERT INTO therapists (name, email, specialization) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $specialization);

    if ($stmt->execute()) {
        $message = "✅ Therapist added successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Therapist</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #2c3e50, #3498db); color: #fff; display: flex; justify-content: center; align-items: center; min-height: 100vh;}
        .form-container { background: rgba(255,255,255,0.1); padding: 25px; border-radius: 15px; width: 400px;}
        h2 { text-align: center; margin-bottom: 20px; }
        input, button { width: 100%; margin: 8px 0; padding: 10px; border-radius: 8px; border: none; }
        button { background: #3498db; color: #fff; font-weight: bold; }
        button:hover { background: #1abc9c; }
        .message { text-align: center; margin-bottom: 10px;}
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Therapist</h2>
        <div class="message"><?php echo $message; ?></div>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="specialization" placeholder="Specialization" required>
            <button type="submit">Add Therapist</button>
        </form>
    </div>
</body>
</html>
