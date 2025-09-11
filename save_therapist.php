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
    $specialization = $_POST['specialization'] ?? null;
    $experience_years = isset($_POST['experience_years']) ? (int) $_POST['experience_years'] : null;
    $bio = $_POST['bio'] ?? null;

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
            $user_id = $stmt->insert_id; // ✅ Get new user_id

            // If the role is therapist, insert into therapists table
            if ($role === 'therapist') {
                $therapist_sql = "INSERT INTO therapists (user_id, specialization, experience_years, bio) VALUES (?, ?, ?, ?)";
                $therapist_stmt = $conn->prepare($therapist_sql);
                if ($therapist_stmt) {
                    $therapist_stmt->bind_param("isis", $user_id, $specialization, $experience_years, $bio);
                    if (!$therapist_stmt->execute()) {
                        die("❌ Error inserting therapist details: " . $therapist_stmt->error);
                    }
                    $therapist_stmt->close();
                } else {
                    die("❌ Error preparing therapist statement: " . $conn->error);
                }
            }  

            // ✅ Redirect after all inserts are done
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
