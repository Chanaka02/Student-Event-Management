<?php
require_once __DIR__.'/../src/event_actions.php';
require_once __DIR__.'/../src/auth.php';
require_login();
$events = get_events();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Events</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.5);animation:fadeIn .2s ease}
    .modal.active{display:flex;align-items:center;justify-content:center}
    .modal-content{background:#fff;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,0.3);max-width:500px;width:90%;padding:32px;max-height:80vh;overflow-y:auto;animation:slideUp .3s ease}
    .modal-header{display:flex;justify-content:space-between;align-items:start;margin-bottom:16px}
    .modal-header h2{margin:0;color:#0f172a;font-size:1.5rem}
    .modal-close{background:0;border:0;font-size:24px;cursor:pointer;color:#64748b;transition:color .2s}
    .modal-close:hover{color:#0f172a}
    .modal-body{color:#374151;line-height:1.6}
    .modal-meta{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin:16px 0;padding:16px;background:#f8fafc;border-radius:8px}
    .modal-meta-item{display:flex;flex-direction:column;gap:4px}
    .modal-meta-label{font-weight:600;color:#0f172a;font-size:0.85rem;text-transform:uppercase}
    .modal-meta-value{color:#374151;font-size:0.95rem}
    @keyframes fadeIn{from{opacity:0}to{opacity:1}}
    @keyframes slideUp{from{transform:translateY(20px);opacity:0}to{transform:translateY(0);opacity:1}}
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

    <div class="events-header">
      <h1>Upcoming Events</h1>
      <p>Browse and register for amazing student events and opportunities</p>
    </div>

    <div class="events-container">
      <?php if(count($events) === 0): ?>
        <div class="empty-state">
          <div style="font-size:3rem;margin-bottom:16px">📭</div>
          <h3>No events yet</h3>
          <p>Check back soon for upcoming events!</p>
        </div>
      <?php else: ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px">
          <?php foreach($events as $e): ?>
            <div class="event-card">
              <div class="event-card-header">
                <h3 class="event-card-title"><?=htmlspecialchars($e['title'])?></h3>
              </div>
              <div class="event-card-body">
                <div class="event-card-meta">
                  <div class="event-meta-item">
                    <span>📅</span>
                    <span><?=htmlspecialchars($e['date'])?></span>
                  </div>
                  <div class="event-meta-item">
                    <span>📍</span>
                    <span><?=htmlspecialchars($e['venue'] ?? 'TBA')?></span>
                  </div>
                </div>
                <div class="event-card-desc"><?=nl2br(htmlspecialchars(substr($e['description'], 0, 150)))?><?=strlen($e['description']) > 150 ? '...' : ''?></div>
                <div class="event-card-footer">
                  <a class="event-btn" href="register.php?event_id=<?=$e['event_id']?>">Register Now</a>
                  <button class="event-btn secondary" onclick="openModal(<?=$e['event_id']?>)">View Details</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Event Details Modal -->
    <div id="eventModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2 id="modalTitle">Event Details</h2>
          <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
          <div class="modal-meta">
            <div class="modal-meta-item">
              <span class="modal-meta-label">📅 Date</span>
              <span class="modal-meta-value" id="modalDate">-</span>
            </div>
            <div class="modal-meta-item">
              <span class="modal-meta-label">📍 Venue</span>
              <span class="modal-meta-value" id="modalVenue">-</span>
            </div>
          </div>
          <div style="margin-top:20px">
            <h4 style="margin-top:0;color:#0f172a">Description</h4>
            <p id="modalDescription" style="margin:0"></p>
          </div>
        </div>
      </div>
    </div>

    <script>
      const events = <?=json_encode($events)?>;
      
      function openModal(eventId) {
        const event = events.find(e => e.event_id == eventId);
        if (!event) return;
        
        document.getElementById('modalTitle').textContent = event.title;
        document.getElementById('modalDate').textContent = event.date;
        document.getElementById('modalVenue').textContent = event.venue || 'TBA';
        document.getElementById('modalDescription').textContent = event.description;
        
        document.getElementById('eventModal').classList.add('active');
      }
      
      function closeModal() {
        document.getElementById('eventModal').classList.remove('active');
      }
      
      document.getElementById('eventModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
      });
    </script>

    <footer>&copy; 2025 Student Event Management System</footer>
  </div>
</body>
</html>
