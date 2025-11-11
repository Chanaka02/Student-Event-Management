<?php
require_once __DIR__.'/../src/event_actions.php';
require_once __DIR__.'/../src/auth.php';
require_login();
$evt = null;
if(isset($_GET['event_id'])) $evt = get_event((int)$_GET['event_id']);
$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $e = $_POST['event_id'];
    $name = trim($_POST['name']);
    $student = trim($_POST['student_id']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    if($name && $student && filter_var($email, FILTER_VALIDATE_EMAIL)){
        register_attendee($e,$name,$student,$email,$contact);
        $msg = 'Registered successfully';
    } else { $msg = 'Please fill required fields correctly'; }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Event Registration</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .reg-header{background:var(--gradient-accent);color:#fff;padding:32px 24px;border-radius:var(--radius);margin-bottom:28px;box-shadow:0 12px 32px rgba(59,130,246,0.25)}
    .reg-header h1{margin:0 0 8px 0;font-size:2rem;font-weight:800}
    .reg-header .event-name{font-size:1.1rem;opacity:0.95}
    .reg-container{max-width:600px;margin:0 auto}
    .reg-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;border:1px solid #e2e8f0}
    .reg-card-header{background:linear-gradient(135deg, rgba(59,130,246,0.05), rgba(139,92,246,0.05));padding:24px;border-bottom:1px solid #e2e8f0}
    .reg-card-header h3{margin:0;color:var(--primary);font-size:1.25rem}
    .reg-card-body{padding:32px}
    .reg-form{display:flex;flex-direction:column;gap:20px}
    .form-group{display:flex;flex-direction:column;gap:8px}
    .form-group label{font-weight:600;color:var(--primary);font-size:0.95rem;display:flex;align-items:center;gap:8px}
    .form-group label span{opacity:0.7}
    .form-group input{padding:12px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:0.95rem;transition:all .2s ease;background:#f8fafc}
    .form-group input:focus{outline:0;border-color:var(--accent);box-shadow:0 0 0 4px rgba(59,130,246,0.1);background:#fff}
    .form-group .form-help{font-size:0.8rem;color:var(--muted);margin-top:4px}
    .reg-alert{background:linear-gradient(135deg, #dbeafe, #bfdbfe);color:#1e40af;padding:16px;border-radius:8px;border-left:4px solid var(--accent);margin-bottom:20px;display:flex;gap:12px;align-items:flex-start}
    .reg-alert-icon{font-size:1.5rem}
    .reg-alert-text{flex:1;line-height:1.5}
    .reg-success{background:linear-gradient(135deg, #dcfce7, #bbf7d0);color:#166534;border-left-color:#22c55e}
    .reg-success .reg-alert-icon{color:#22c55e}
    .reg-footer{display:flex;gap:12px;margin-top:28px;padding-top:28px;border-top:1px solid #e2e8f0}
    .reg-submit{background:var(--gradient-accent);color:#fff;padding:14px 24px;border:0;border-radius:8px;font-weight:700;cursor:pointer;transition:all .2s ease;flex:1;box-shadow:0 8px 16px rgba(59,130,246,0.3);font-size:1rem}
    .reg-submit:hover{transform:translateY(-2px);box-shadow:0 12px 24px rgba(59,130,246,0.4)}
    .reg-back{background:#f1f5f9;color:var(--primary);padding:14px 24px;border:1.5px solid #cbd5e1;border-radius:8px;font-weight:600;text-decoration:none;text-align:center;transition:all .2s ease;cursor:pointer}
    .reg-back:hover{background:var(--accent);color:#fff;border-color:var(--accent)}
    .reg-info{background:linear-gradient(135deg, rgba(139,92,246,0.05), rgba(59,130,246,0.05));padding:20px;border-radius:8px;margin-top:20px;border-left:4px solid var(--secondary)}
    .reg-info h4{margin:0 0 8px 0;color:var(--primary);font-size:0.95rem}
    .reg-info p{margin:0;color:#374151;font-size:0.9rem;line-height:1.6}
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>🎓 Student Events</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="events.php">Events</a>
        <?php if(current_user()): ?>
          <span class="muted">Hello, <?=htmlspecialchars(current_user()['name'])?></span>
          <?php if(isset(current_user()['role']) && current_user()['role'] === 'admin'): ?>
            <a href="admin.php">⚙️ Admin</a>
          <?php endif; ?>
          <a href="login.php?logout=1">Logout</a>
        <?php else: ?>
          <a href="login.php">Login</a>
          <a href="signup.php">Sign up</a>
        <?php endif; ?>
      </nav>
    </header>

    <div class="reg-header">
      <h1>📝 Event Registration</h1>
      <div class="event-name">
        <?php if($evt): ?>
          📌 <strong><?=htmlspecialchars($evt['title'])?></strong>
        <?php else: ?>
          Please select an event to register
        <?php endif; ?>
      </div>
    </div>

    <div class="reg-container">
      <?php if($msg && strpos($msg, 'success') !== false): ?>
        <div class="reg-alert reg-success">
          <span class="reg-alert-icon">✅</span>
          <div class="reg-alert-text"><strong>Registration Successful!</strong><br><?=htmlspecialchars($msg)?></div>
        </div>
      <?php elseif($msg): ?>
        <div class="reg-alert">
          <span class="reg-alert-icon">⚠️</span>
          <div class="reg-alert-text"><?=htmlspecialchars($msg)?></div>
        </div>
      <?php endif; ?>

      <?php if($evt): ?>
        <div class="reg-card">
          <div class="reg-card-header">
            <h3>📋 Your Registration Details</h3>
          </div>
          <div class="reg-card-body">
            <form method="post" id="regForm" class="reg-form">
              <input type="hidden" name="event_id" value="<?=htmlspecialchars($_GET['event_id'] ?? '')?>">

              <div class="form-group">
                <label for="name">Full Name <span>*</span></label>
                <input id="name" name="name" type="text" placeholder="e.g., John Doe" required>
                <span class="form-help">Your full name as shown in student records</span>
              </div>

              <div class="form-group">
                <label for="student_id">Student ID <span>*</span></label>
                <input id="student_id" name="student_id" type="text" placeholder="e.g., STU20250001" required>
                <span class="form-help">Your unique student identification number</span>
              </div>

              <div class="form-group">
                <label for="email">Email Address <span>*</span></label>
                <input id="email" name="email" type="email" placeholder="your@email.com" required>
                <span class="form-help">We'll use this to send you event updates</span>
              </div>

              <div class="form-group">
                <label for="contact">Contact Number <span>(Optional)</span></label>
                <input id="contact" name="contact" type="tel" placeholder="+1 (555) 000-0000">
                <span class="form-help">For event organizers to reach you if needed</span>
              </div>

              <div class="reg-footer">
                <button type="submit" class="reg-submit">✅ Complete Registration</button>
                <a href="events.php" class="reg-back">← Back</a>
              </div>
            </form>

            <div class="reg-info">
              <h4>ℹ️ Important Information</h4>
              <p>Please ensure all details are accurate. We'll send a confirmation email to the address you provide. If you have any questions, contact the event organizers.</p>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="reg-card">
          <div class="reg-card-body" style="text-align:center;padding:48px 32px">
            <div style="font-size:3rem;margin-bottom:16px">📭</div>
            <h3 style="margin:0 0 8px 0;color:var(--primary)">No Event Selected</h3>
            <p style="margin:0;color:var(--muted)">Please go back to the events page and select an event to register for.</p>
            <a href="events.php" style="display:inline-block;margin-top:20px;background:var(--gradient-accent);color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:600">← Back to Events</a>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <footer>&copy; 2025 Student Event Management System</footer>
  </div>

  <script src="assets/js/app.js"></script>
</body>
</html>
