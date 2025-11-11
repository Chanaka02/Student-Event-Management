<?php
require_once __DIR__.'/../src/auth.php';
require_once __DIR__.'/../src/event_actions.php';
require_login();
if(!current_user() || current_user()['role'] !== 'admin'){ echo "Access denied"; exit; }
$evt = null;
if(isset($_GET['event_id'])) $evt = get_event((int)$_GET['event_id']);
$regs = $evt ? get_registrations($evt['event_id']) : [];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Event Registrations</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .reg-list-header{background:var(--gradient-accent);color:#fff;padding:24px;border-radius:var(--radius);margin-bottom:28px}
    .reg-list-header h1{margin:0 0 4px 0;font-size:1.8rem;font-weight:800}
    .reg-list-header p{margin:0;opacity:0.95}
    .reg-list-card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;border:1px solid #e2e8f0}
    .reg-list-header-card{background:linear-gradient(135deg, rgba(59,130,246,0.05), rgba(139,92,246,0.05));padding:20px;border-bottom:1px solid #e2e8f0}
    .reg-list-header-card h3{margin:0;color:var(--primary);font-size:1.25rem}
    .reg-list-body{padding:0}
    .reg-item{padding:16px 20px;border-bottom:1px solid #e2e8f0;display:flex;flex-direction:column;gap:12px;transition:all .2s ease}
    .reg-item:last-child{border-bottom:0}
    .reg-item:hover{background:#f8fafc}
    .reg-info{display:flex;flex-direction:column;gap:8px}
    .reg-name{font-weight:700;color:var(--primary);margin:0;font-size:1rem}
    .reg-meta{display:flex;gap:30px;font-size:0.9rem;color:var(--muted);align-items:center;flex-wrap:wrap}
    .reg-meta div{display:flex;gap:4px;white-space:nowrap}
    .reg-meta strong{color:var(--primary);font-weight:600}
    .reg-time{white-space:nowrap;color:var(--muted);font-size:0.9rem;margin-left:auto}
    .empty-reg{text-align:center;padding:40px 20px;color:var(--muted)}
    .empty-reg-icon{font-size:2.5rem;margin-bottom:12px}
    @media(max-width:768px){
      .reg-item{flex-direction:column;align-items:flex-start;gap:12px}
      .reg-meta{flex-direction:column;gap:8px}
      .reg-time{text-align:left}
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>⚙️ Admin Dashboard</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="events.php">Events</a>
        <a href="admin.php">Admin</a>
        <a href="login.php?logout=1">Logout</a>
      </nav>
    </header>

    <div class="reg-list-header">
      <h1>👥 Event Registrations</h1>
      <p>
        <?php if($evt): ?>
          Showing all registrations for: <strong><?=htmlspecialchars($evt['title'])?></strong>
        <?php else: ?>
          No event selected
        <?php endif; ?>
      </p>
    </div>

    <?php if($evt): ?>
      <div class="reg-list-card">
        <div class="reg-list-header-card">
          <h3>📋 Registered Attendees (<?=count($regs)?>)</h3>
        </div>
        <div class="reg-list-body">
          <?php if(count($regs) === 0): ?>
            <div class="empty-reg">
              <div class="empty-reg-icon">📭</div>
              <p>No registrations yet for this event.</p>
            </div>
          <?php else: ?>
            <?php foreach($regs as $r): ?>
              <div class="reg-item">
                <div class="reg-name"><?=htmlspecialchars($r['name'])?></div>
                <div class="reg-meta">
                  <div><strong>ID:</strong> <?=htmlspecialchars($r['student_id'])?></div>
                  <div><strong>Email:</strong> <?=htmlspecialchars($r['email'])?></div>
                  <div><strong>Contact:</strong> <?=htmlspecialchars($r['contact'] ?? 'N/A')?></div>
                  <div class="reg-time"><strong>Date:</strong> <?=htmlspecialchars(date('M d, Y', strtotime($r['timestamp'])))?></div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    <?php else: ?>
      <div class="reg-list-card">
        <div class="reg-list-body">
          <div class="empty-reg">
            <div class="empty-reg-icon">📭</div>
            <h3 style="margin:0 0 8px 0;color:var(--primary)">No Event Selected</h3>
            <p>Please go back to admin dashboard to select an event.</p>
            <a href="admin.php" style="display:inline-block;margin-top:16px;background:var(--gradient-accent);color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:600">← Back to Admin</a>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div style="text-align:center;margin-top:28px">
      <a href="admin.php" class="btn btn-secondary">← Back to Admin Dashboard</a>
    </div>

    <footer>&copy; 2025 Student Event Management System</footer>
  </div>
</body>
</html>
