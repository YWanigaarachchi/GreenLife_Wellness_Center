<?php 
session_start();
include("db.php"); // DB connection

// Fetch all members
$users = [];
$sql = "SELECT user_id, first_name, last_name, email, phone, role FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result) {
  while($row = $result->fetch_assoc()){
    $users[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - GreenLife Wellness</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #2e8b57;
      --primary-dark: #246b44;
      --secondary: #e6f9ed;
      --accent: #1abc9c;
      --bg-color: #f4f7f6;
      --sidebar-bg: #ffffff;
      --text-dark: #2c3e50;
      --text-muted: #7f8c8d;
      --danger: #e74c3c;
      --danger-dark: #c0392b;
      --white: #ffffff;
      --border: #eaedf1;
      --shadow: 0 4px 6px rgba(0,0,0,0.05);
      --shadow-hover: 0 10px 15px rgba(0,0,0,0.1);
      --transition: all 0.3s ease;
      --radius: 12px;
    }

    * { margin:0; padding:0; box-sizing:border-box; font-family: 'Inter', sans-serif; }
    
    body { background-color: var(--bg-color); color: var(--text-dark); display: flex; min-height: 100vh; overflow-x: hidden; }
    
    /* Sidebar */
    .sidebar { width: 260px; background: var(--sidebar-bg); border-right: 1px solid var(--border); padding: 30px 20px; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 100; transition: var(--transition); box-shadow: var(--shadow); }
    .sidebar-header { text-align: center; margin-bottom: 40px; }
    .sidebar-header h2 { font-size: 24px; color: var(--primary); font-weight: 700; letter-spacing: 0.5px; }
    .sidebar-header h2 span { color: var(--text-dark); }
    
    .nav-links { list-style: none; flex: 1; }
    .nav-links li { margin-bottom: 10px; }
    .nav-links a { display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: var(--text-muted); font-weight: 500; border-radius: 8px; transition: var(--transition); }
    .nav-links a i { margin-right: 15px; font-size: 18px; width: 20px; text-align: center; }
    .nav-links a:hover, .nav-links a.active { background: var(--secondary); color: var(--primary); }
    
    .logout-btn { background: #fee2e2; color: var(--danger); }
    .logout-btn:hover { background: var(--danger); color: var(--white) !important; }

    /* Main Content */
    .main-content { flex: 1; padding: 40px; margin-left: 260px; max-width: calc(100% - 260px); }
    
    /* Top Header */
    .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
    .top-header h1 { font-size: 28px; font-weight: 700; color: var(--text-dark); }
    .user-profile { display: flex; align-items: center; gap: 15px; background: var(--white); padding: 8px 15px; border-radius: 30px; box-shadow: var(--shadow); }
    .user-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    .user-profile .info span { display: block; font-size: 14px; font-weight: 600; }
    .user-profile .info small { color: var(--text-muted); font-size: 12px; }

    /* Action Cards */
    .section-title { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
    
    .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 40px; }
    .card { background: var(--white); padding: 25px; border-radius: var(--radius); box-shadow: var(--shadow); transition: var(--transition); border: 1px solid var(--border); position: relative; overflow: hidden; }
    .card:hover { transform: translateY(-5px); box-shadow: var(--shadow-hover); border-color: var(--primary); }
    
    .card-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 20px; }
    .card-admin .card-icon { background: #e0e7ff; color: #4f46e5; }
    .card-client .card-icon { background: #dcfce7; color: #16a34a; }
    .card-therapist .card-icon { background: #fef08a; color: #ca8a04; }
    
    .card h3 { font-size: 18px; margin-bottom: 10px; color: var(--text-dark); }
    .card p { color: var(--text-muted); font-size: 14px; margin-bottom: 20px; }
    
    .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 14px; transition: var(--transition); display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-primary { background: var(--primary); color: var(--white); width: 100%; }
    .btn-primary:hover { background: var(--primary-dark); }
    
    /* Table Section */
    .table-container { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); padding: 25px; overflow-x: auto; }
    .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .table-header h3 { font-size: 20px; font-weight: 600; }
    
    table { width: 100%; border-collapse: collapse; min-width: 800px; }
    th, td { padding: 15px 20px; text-align: left; border-bottom: 1px solid var(--border); }
    th { background: #f8fafc; color: var(--text-muted); font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
    td { font-size: 14px; color: var(--text-dark); font-weight: 500; }
    tr:hover td { background: #f1f5f9; }
    
    .role-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: capitalize; }
    .role-admin { background: #e0e7ff; color: #4f46e5; }
    .role-client { background: #dcfce7; color: #16a34a; }
    .role-therapist { background: #fef08a; color: #ca8a04; }
    
    .btn-sm { padding: 6px 12px; font-size: 13px; border-radius: 4px; }
    .btn-danger { background: #fee2e2; color: var(--danger); border: 1px solid transparent; }
    .btn-danger:hover { background: var(--danger); color: var(--white); }

    /* Modal Styles */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
    .modal.show { display: flex; opacity: 1; }
    
    .modal-content { background: var(--white); padding: 30px; border-radius: var(--radius); width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: translateY(-20px); transition: transform 0.3s ease; max-height: 90vh; overflow-y: auto; }
    .modal.show .modal-content { transform: translateY(0); }
    
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 15px; }
    .modal-header h2 { font-size: 22px; color: var(--text-dark); }
    .close-btn { background: transparent; border: none; font-size: 24px; color: var(--text-muted); cursor: pointer; transition: color 0.2s; }
    .close-btn:hover { color: var(--danger); }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .form-group { margin-bottom: 15px; }
    .form-group.full { grid-column: span 2; }
    .form-group label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: var(--text-muted); }
    .form-group input, .form-group select { width: 100%; padding: 10px 15px; border: 1px solid var(--border); border-radius: 6px; font-size: 14px; transition: border-color 0.3s, box-shadow 0.3s; background: #f8fafc; }
    .form-group input:focus, .form-group select:focus { outline: none; border-color: var(--primary); background: var(--white); box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.1); }
    
    .action-btns { margin-top: 25px; display: flex; gap: 10px; justify-content: flex-end; }
    .btn-cancel { background: #f1f5f9; color: var(--text-dark); }
    .btn-cancel:hover { background: #e2e8f0; }

    /* Responsive */
    @media (max-width: 1024px) {
      .sidebar { width: 80px; padding: 20px 10px; }
      .sidebar-header h2 span { display: none; }
      .sidebar-header h2 { font-size: 14px; }
      .nav-links a span { display: none; }
      .nav-links a i { margin: 0; font-size: 20px; }
      .main-content { margin-left: 80px; max-width: calc(100% - 80px); }
    }
    @media (max-width: 768px) {
      .cards-grid { grid-template-columns: 1fr; }
      .form-grid { grid-template-columns: 1fr; }
      .form-group.full { grid-column: span 1; }
      .main-content { padding: 20px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2><i class="fa-solid fa-leaf"></i> <span>GreenLife</span></h2>
    </div>
    
    <ul class="nav-links">
      <li><a href="admin_Dashboard.php" class="active"><i class="fa-solid fa-house"></i> <span>Dashboard</span></a></li>
      <li><a href="admin_clients.php"><i class="fa-solid fa-users"></i> <span>Manage Clients</span></a></li>
      <li><a href="admin_appointments.php"><i class="fa-solid fa-calendar-check"></i> <span>Appointments</span></a></li>
      <li><a href="admin_inquiries.php"><i class="fa-solid fa-comment-dots"></i> <span>Inquiries</span></a></li>
      <li><a href="admin_reports.php"><i class="fa-solid fa-chart-line"></i> <span>Reports</span></a></li>
    </ul>

    <ul class="nav-links" style="flex: 0;">
      <li><a href="logout.php" class="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> <span>Log Out</span></a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    
    <div class="top-header">
      <div>
        <h1>Welcome, Admin!</h1>
        <p style="color: var(--text-muted); margin-top: 5px;">Manage users and system settings</p>
      </div>
      
      <div class="user-profile">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=2e8b57&color=fff" alt="Admin">
        <div class="info">
          <span>Administrator</span>
          <small>admin@greenlife.com</small>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <h3 class="section-title">Quick Actions</h3>
    <div class="cards-grid">
      <!-- Admin Card -->
      <div class="card card-admin">
        <div class="card-icon"><i class="fa-solid fa-user-shield"></i></div>
        <h3>Add Admin</h3>
        <p>Create a new administrator account with full system access.</p>
        <button class="btn btn-primary" onclick="openModal('adminModal')"><i class="fa-solid fa-plus"></i> New Admin</button>
      </div>

      <!-- Client Card -->
      <div class="card card-client">
        <div class="card-icon"><i class="fa-solid fa-user"></i></div>
        <h3>Add Client</h3>
        <p>Register a new client/member to the wellness center.</p>
        <button class="btn btn-primary" onclick="openModal('clientModal')"><i class="fa-solid fa-plus"></i> New Client</button>
      </div>

      <!-- Therapist Card -->
      <div class="card card-therapist">
        <div class="card-icon"><i class="fa-solid fa-user-doctor"></i></div>
        <h3>Add Therapist</h3>
        <p>Onboard a new specialist or therapist to the team.</p>
        <button class="btn btn-primary" onclick="openModal('therapistModal')"><i class="fa-solid fa-plus"></i> New Therapist</button>
      </div>
    </div>

    <!-- Users Table -->
    <div class="table-container">
      <div class="table-header">
        <h3><i class="fa-solid fa-users-gear" style="color: var(--primary); margin-right: 10px;"></i> All System Users</h3>
      </div>
      
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($users) > 0): ?>
            <?php foreach($users as $u): ?>
            <tr>
              <td>#<?php echo str_pad($u['user_id'], 4, '0', STR_PAD_LEFT); ?></td>
              <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                  <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($u['first_name']." ".$u['last_name']); ?>&background=random&color=fff&size=32" style="border-radius:50%;" alt="Avatar">
                  <?php echo htmlspecialchars($u['first_name']." ".$u['last_name']); ?>
                </div>
              </td>
              <td><?php echo htmlspecialchars($u['email']); ?></td>
              <td><?php echo htmlspecialchars($u['phone']); ?></td>
              <td>
                <span class="role-badge role-<?php echo strtolower($u['role']); ?>">
                  <?php echo ucfirst($u['role']); ?>
                </span>
              </td>
              <td>
                <form style="display:inline-block;" action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                  <input type="hidden" name="user_id" value="<?php echo $u['user_id']; ?>">
                  <button type="submit" class="btn btn-sm btn-danger" title="Delete User"><i class="fa-solid fa-trash"></i> Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">No users found in the system.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>

  <!-- Modals -->

  <!-- Admin Modal -->
  <div class="modal" id="adminModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fa-solid fa-user-shield" style="color: #4f46e5; margin-right: 10px;"></i> Add New Admin</h2>
        <button type="button" class="close-btn" onclick="closeModal('adminModal')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form action="save_user.php" method="POST">
        <input type="hidden" name="role" value="admin">
        <div class="form-grid">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="John" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Doe" required>
          </div>
          <div class="form-group full">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="admin@example.com" required>
          </div>
          <div class="form-group full">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="+1 234 567 8900" required>
          </div>
          <div class="form-group full">
            <label>Username</label>
            <input type="text" name="username" placeholder="admin_user" required>
          </div>
          <div class="form-group full">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
          </div>
        </div>
        <div class="action-btns">
          <button type="button" class="btn btn-cancel" onclick="closeModal('adminModal')">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background:#4f46e5;">Save Admin Account</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Client Modal -->
  <div class="modal" id="clientModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fa-solid fa-user" style="color: #16a34a; margin-right: 10px;"></i> Add New Client</h2>
        <button type="button" class="close-btn" onclick="closeModal('clientModal')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form action="save_user.php" method="POST">
        <input type="hidden" name="role" value="client">
        <div class="form-grid">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="Jane" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Smith" required>
          </div>
          <div class="form-group full">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="client@example.com" required>
          </div>
          <div class="form-group full">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="+1 234 567 8900" required>
          </div>
          <div class="form-group full">
            <label>Username</label>
            <input type="text" name="username" placeholder="client_user" required>
          </div>
          <div class="form-group full">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
          </div>
        </div>
        <div class="action-btns">
          <button type="button" class="btn btn-cancel" onclick="closeModal('clientModal')">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background:#16a34a;">Save Client Profile</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Therapist Modal -->
  <div class="modal" id="therapistModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fa-solid fa-user-doctor" style="color: #ca8a04; margin-right: 10px;"></i> Add New Therapist</h2>
        <button type="button" class="close-btn" onclick="closeModal('therapistModal')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form action="save_therapist.php" method="POST">
        <input type="hidden" name="role" value="therapist">
        <div class="form-grid">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="Dr. Sarah" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Connor" required>
          </div>
          <div class="form-group full">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="therapist@example.com" required>
          </div>
          <div class="form-group full">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="+1 234 567 8900" required>
          </div>
          <div class="form-group full">
            <label>Specialization</label>
            <select name="specialization" required>
              <option value="" disabled selected>Select specialization...</option>
              <option value="Ayurvedic Specialist">Ayurvedic Specialist</option>
              <option value="Yoga & Meditation Instructor">Yoga & Meditation Instructor</option>
              <option value="Nutrition Consultation">Nutrition Consultation</option>
              <option value="Massage Therapy">Massage Therapy</option>
            </select>
          </div>
          <div class="form-group">
            <label>Experience (Years)</label>
            <input type="number" name="experience_years" placeholder="e.g. 5" required min="0">
          </div>
          <div class="form-group full">
            <label>Username</label>
            <input type="text" name="username" placeholder="therapist_user" required>
          </div>
          <div class="form-group full">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
          </div>
          <div class="form-group full">
            <label>Short Bio</label>
            <input type="text" name="bio" placeholder="Brief description about the therapist..." required>
          </div>
        </div>
        <div class="action-btns">
          <button type="button" class="btn btn-cancel" onclick="closeModal('therapistModal')">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background:#ca8a04;">Save Therapist Profile</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openModal(id){ 
      const modal = document.getElementById(id);
      modal.style.display = 'flex';
      // Trigger reflow
      void modal.offsetWidth;
      modal.classList.add('show');
    }
    
    function closeModal(id){ 
      const modal = document.getElementById(id);
      modal.classList.remove('show');
      setTimeout(() => {
        modal.style.display = 'none';
      }, 300); // Wait for transition to finish
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
        setTimeout(() => {
          event.target.style.display = 'none';
        }, 300);
      }
    }
  </script>
</body>
</html>
