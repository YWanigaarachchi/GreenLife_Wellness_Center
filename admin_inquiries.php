<?php 
session_start();
include("db.php"); // DB connection

// ✅ Fetch feedback + user info
$sql = "
    SELECT f.feedback_id, u.first_name, u.last_name, u.email, 
           f.subject, f.message, f.created_at
    FROM feedback f
    JOIN users u ON f.user_id = u.user_id
    ORDER BY f.created_at DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inquiries - Admin</title>
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
    th,td{padding:12px;text-align:left;border-bottom:1px solid #ddd;vertical-align:top;}
    th{background:#34495e;color:#fff;}
    tr:hover{background:#f4f6f7;}
    button{padding:6px 12px;border:none;border-radius:4px;background:#2980b9;color:#fff;cursor:pointer;}
    button:hover{background:#3498db;}

    /* Replies style */
    .replies {margin-top:8px;padding:8px;background:#f9f9f9;border-left:3px solid #2980b9;border-radius:5px;}
    .reply-item{margin-bottom:6px;padding:6px;background:#ecf0f1;border-radius:5px;}
    .reply-item small{color:#555;display:block;}

    /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.5);}
    .modal-content{background:#fff;margin:10% auto;padding:20px;border-radius:8px;width:400px;position:relative;}
    .close{position:absolute;top:10px;right:15px;font-size:20px;cursor:pointer;color:#333;}
    textarea{width:100%;padding:10px;margin-top:10px;border:1px solid #ccc;border-radius:6px;min-height:100px;}
    .send-btn{margin-top:10px;background:#27ae60;}
    .send-btn:hover{background:#2ecc71;}
    .alert {padding:10px;margin-bottom:15px;border-radius:5px;}
    .success {background:#2ecc71;color:#fff;}
    .error {background:#e74c3c;color:#fff;}
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
    <h1>📨 Client Inquiries</h1>

    <?php if(isset($_SESSION['success'])): ?>
      <div class="alert success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php elseif(isset($_SESSION['error'])): ?>
      <div class="alert error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <table>
      <tr>
        <th>ID</th>
        <th>Name / Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Date</th>
        <th>Replies</th>
        <th>Action</th>
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['feedback_id']); ?></td>
            <td>
              <?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?><br>
              <small><?php echo htmlspecialchars($row['email']); ?></small>
            </td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
            <td><?php echo htmlspecialchars(date("d-M-Y H:i", strtotime($row['created_at']))); ?></td>
            <td>
              <?php
              // ✅ Fetch replies for this feedback
              $fid = $row['feedback_id'];
              $rep_sql = "SELECT reply_message, created_at FROM replies WHERE feedback_id=$fid ORDER BY created_at DESC";
              $rep_res = $conn->query($rep_sql);
              if ($rep_res && $rep_res->num_rows > 0) {
                  echo "<div class='replies'>";
                  while ($rep = $rep_res->fetch_assoc()) {
                      echo "<div class='reply-item'>";
                      echo nl2br(htmlspecialchars($rep['reply_message']));
                      echo "<small>Sent: " . date("d-M-Y H:i", strtotime($rep['created_at'])) . "</small>";
                      echo "</div>";
                  }
                  echo "</div>";
              } else {
                  echo "<em>No replies yet</em>";
              }
              ?>
            </td>
            <td>
              <button onclick="openModal('<?php echo $row['feedback_id']; ?>','<?php echo $row['email']; ?>')">Reply</button>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" style="text-align:center;">No inquiries found</td></tr>
      <?php endif; ?>
    </table>
  </div>

  <!-- Reply Modal -->
  <div id="replyModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h3>Reply to Inquiry</h3>
      <form method="post" action="send_inquiries_reply.php">
        <input type="hidden" name="feedback_id" id="feedbackId">
        <input type="hidden" name="client_email" id="clientEmail">
        <label>Reply Message:</label>
        <textarea name="reply_message" required></textarea>
        <button type="submit" class="send-btn">Send Reply</button>
      </form>
    </div>
  </div>

  <script>
    function openModal(feedbackId, email){
      document.getElementById("replyModal").style.display = "block";
      document.getElementById("feedbackId").value = feedbackId;
      document.getElementById("clientEmail").value = email;
    }
    function closeModal(){
      document.getElementById("replyModal").style.display = "none";
    }
    window.onclick = function(event){
      if(event.target == document.getElementById("replyModal")){
        closeModal();
      }
    }
  </script>
</body>
</html>
