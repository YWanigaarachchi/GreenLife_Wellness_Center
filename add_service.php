<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO services (service_name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $service_name, $description, $price);

    if ($stmt->execute()) {
        $message = "✅ Service added successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Service</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #2c3e50, #3498db); color: #fff; display: flex; justify-content: center; align-items: center; min-height: 100vh;}
        .form-container { background: rgba(255,255,255,0.1); padding: 25px; border-radius: 15px; width: 400px;}
        h2 { text-align: center; margin-bottom: 20px; }
        input, textarea, button { width: 100%; margin: 8px 0; padding: 10px; border-radius: 8px; border: none; }
        textarea { resize: none; }
        button { background: #3498db; color: #fff; font-weight: bold; }
        button:hover { background: #1abc9c; }
        .message { text-align: center; margin-bottom: 10px;}
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Service</h2>
        <div class="message"><?php echo $message; ?></div>
        <form method="POST">
            <input type="text" name="service_name" placeholder="Service Name" required>
            <textarea name="description" placeholder="Service Description" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <button type="submit">Add Service</button>
        </form>
    </div>
</body>
</html>
