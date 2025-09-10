<?php 
session_start();
include("db.php"); // make sure db.php connects to your DB

// Only allow admins
//if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//    header("Location: login.php");
//   exit;
//}

// Handle appointment actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $appointment_id = intval($_POST['appointment_id']);

    if ($action && $appointment_id) {
        if ($action === 'confirm') {
            $stmt = $conn->prepare("UPDATE appointments SET status='confirmed' WHERE appointment_id=?");
            $stmt->bind_param("i", $appointment_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'cancel') {
            $stmt = $conn->prepare("UPDATE appointments SET status='cancelled' WHERE appointment_id=?");
            $stmt->bind_param("i", $appointment_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM appointments WHERE appointment_id=?");
            $stmt->bind_param("i", $appointment_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    // Redirect to avoid form resubmission
    header("Location: admin_appointments.php");
    exit;
}

// Fetch appointments with client + therapist + service info dynamically
$sql = "
    SELECT a.appointment_id, 
           u.first_name, u.last_name, 
           u.first_name AS therapist_name, 
           s.name AS service_name, 
           a.appointment_date, a.appointment_time, 
           a.status, a.notes
    FROM appointments a
    JOIN users u ON a.client_id = u.user_id
    JOIN therapists t ON a.therapist_id = t.therapist_id
    JOIN services s ON a.service_id = s.service_id
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointments - Admin</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:Arial,sans-serif;display:flex;min-height:100vh;background:#ecf0f1;}
.sidebar{width:220px;background:#2c3e50;color:#fff;padding:20px 0;flex-shrink:0;}
.sidebar h2{text-align:center;margin-bottom:20px;font-size:18px;}
.sidebar a{display:block;color:#fff;padding:12px 20px;text-decoration:none;transition:background 0.3s;}
.sidebar a:hover{background:#34495e;}
.main{flex:1;padding:30px;}
h1{margin-bottom:20px;color:#2c3e50;}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.1);}
th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#34495e;color:#fff;}
tr:hover{background:#f4f6f7;}
button{padding:6px 12px;margin-right:4px;border:none;border-radius:4px;cursor:pointer;color:#fff;}
.confirm{background:#2a9d8f;}
.cancel{background:#e63946;}
.delete{background:#6c757d;}
button:hover{opacity:0.9;}
</style>
</head>
<body>
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_clients.php">Manage Clients</a>
    <a href="admin_appointments.php">Appointments</a>
    <a href="admin_inquiries.php">Inquiries</a>
    <a href="admin_reports.php">Reports</a>
    <a href="logout.php">Log Out</a>
  </div>

  <div class="main">
    <h1>📅 Appointments</h1>
    <table>
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Therapist</th>
        <th>Service</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Notes</th>
        <th>Actions</th>
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['appointment_id']); ?></td>
            <td><?= htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
            <td><?= htmlspecialchars($row['therapist_name']); ?></td>
            <td><?= htmlspecialchars($row['service_name']); ?></td>
            <td><?= htmlspecialchars(date("d M Y", strtotime($row['appointment_date']))); ?></td>
            <td><?= htmlspecialchars(date("h:i A", strtotime($row['appointment_time']))); ?></td>
            <td><?= ucfirst($row['status']); ?></td>
            <td><?= htmlspecialchars($row['notes']); ?></td>
            <td>
              <form method="POST" style="display:inline;">
                <input type="hidden" name="appointment_id" value="<?= $row['appointment_id']; ?>">
                <?php if ($row['status'] === 'pending'): ?>
                  <button type="submit" name="action" value="confirm" class="confirm">Confirm</button>
                  <button type="submit" name="action" value="cancel" class="cancel">Cancel</button>
                <?php elseif ($row['status'] === 'confirmed'): ?>
                  <button type="submit" name="action" value="cancel" class="cancel">Cancel</button>
                <?php endif; ?>
                <button type="submit" name="action" value="delete" class="delete">Delete</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="9" style="text-align:center;">No appointments found</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
