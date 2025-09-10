<?php 
session_start();
include("db.php"); 

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Show success message if redirected after submission
$success_message = "";
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "✅ Inquiry submitted successfully!";
}

// Fetch inquiries with replies
$sql = "
    SELECT f.feedback_id, f.subject, f.message, f.created_at,
           r.reply_message, r.created_at AS reply_date
    FROM feedback f
    LEFT JOIN replies r ON f.feedback_id = r.feedback_id
    WHERE f.user_id = ?
    ORDER BY f.created_at DESC, r.created_at DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Group results by inquiry
$inquiries = [];
while ($row = $result->fetch_assoc()) {
    $fid = $row['feedback_id'];
    if (!isset($inquiries[$fid])) {
        $inquiries[$fid] = [
            'subject' => $row['subject'],
            'message' => $row['message'],
            'created_at' => $row['created_at'],
            'replies' => []
        ];
    }
    if (!empty($row['reply_message'])) {
        $inquiries[$fid]['replies'][] = [
            'reply_message' => $row['reply_message'],
            'reply_date' => $row['reply_date']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inquiries - GreenLife Wellness</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
      background: #ecf0f1;
    }
    .sidebar {
      width: 220px;
      background: #2c3e50;
      color: #fff;
      padding: 20px 0;
      flex-shrink: 0;
    }
    .sidebar h2 { text-align: center; margin-bottom: 20px; font-size: 18px; }
    .sidebar a {
      display: block;
      color: #fff;
      padding: 12px 20px;
      text-decoration: none;
      transition: background 0.3s;
    }
    .sidebar a:hover { background: #34495e; }
    .main {
      flex: 1;
      padding: 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card h3 { margin-bottom: 15px; color: #2c3e50; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; vertical-align: top; }
    th { background: #8e44ad; color: #fff; }
    .success-message {
      background: #28a745;
      color: #fff;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
      text-align: center;
    }
    .replies { margin-top:8px; padding:8px; background:#f9f9f9; border-left:3px solid #8e44ad; border-radius:5px; }
    .reply-item { margin-bottom:6px; padding:6px; background:#f0f0f0; border-radius:5px; }
    .reply-item small { color:#555; display:block; }
    @media(max-width: 768px) {
      body { flex-direction: column; }
      .sidebar { width: 100%; display: flex; overflow-x: auto; }
      .sidebar a { flex: 1; text-align: center; }
      .main { grid-template-columns: 1fr; }
      table { font-size: 14px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Client Dashboard <br> GreenLife Wellness</h2>
    <a href="client_dashboard.php">🏠 Home</a>
    <a href="profile.php">👤 Profile</a>
    <a href="book_appointment.php">📅 Appointments</a>
    <a href="inquiry.php">💬 Inquiries</a>
    <a href="logout.php">🚪 Log Out</a>
  </div>

  <div class="main">
    
    <!-- My Inquiries -->
    <div class="card">
      <h3>📩 My Inquiries & Replies</h3>
      <?php if ($success_message): ?>
        <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
      <?php endif; ?>
      <table>
        <tr>
          <th>Date</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Admin Reply</th>
        </tr>
        <?php if (!empty($inquiries)): ?>
          <?php foreach ($inquiries as $inq): ?>
            <tr>
              <td><?= date("d M Y", strtotime($inq['created_at'])) ?></td>
              <td><?= htmlspecialchars($inq['subject']) ?></td>
              <td><?= nl2br(htmlspecialchars($inq['message'])) ?></td>
              <td>
                <?php if (!empty($inq['replies'])): ?>
                  <div class="replies">
                    <?php foreach ($inq['replies'] as $rep): ?>
                      <div class="reply-item">
                        <?= nl2br(htmlspecialchars($rep['reply_message'])) ?>
                        <small>📅 <?= date("d M Y H:i", strtotime($rep['reply_date'])) ?></small>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php else: ?>
                  <em>No reply yet</em>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4">No inquiries yet.</td></tr>
        <?php endif; ?>
      </table>
    </div>

    <!-- New Inquiry -->
    <div class="card">
      <h3>➕ New Inquiry</h3>
      <form action="save_inquiry.php" method="POST">
        <label>Subject:</label><br>
        <input type="text" name="subject" required style="width:100%; padding:8px; margin:8px 0;"><br>
        
        <label>Message:</label><br>
        <textarea name="message" rows="5" required style="width:100%; padding:8px; margin:8px 0;"></textarea><br>
        
        <button type="submit" style="background:#8e44ad; color:#fff; padding:10px 15px; border:none; border-radius:5px; cursor:pointer;">
          Submit Inquiry
        </button>
      </form>
    </div>

  </div>

</body>
</html>
