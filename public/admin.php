<?php
require_once __DIR__.'/../src/auth.php';
require_once __DIR__.'/../src/event_actions.php';
require_login();
if(!current_user() || current_user()['role'] !== 'admin'){
    echo "Access denied"; exit;
}

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['create'])){
        create_event($_POST['title'],$_POST['date'],$_POST['venue'],$_POST['description']);
        $msg = 'Event created successfully!';
    }
    if(isset($_POST['edit'])){
        editEvent((int)$_POST['event_id'],$_POST['title'],$_POST['date'],$_POST['venue'],$_POST['description']);
        $msg = 'Event updated successfully!';
        header('Location: admin.php');
        exit;
    }
    if(isset($_POST['delete'])){ 
        delete_event((int)$_POST['event_id']); 
        $msg='Event deleted successfully!';
        header('Location: admin.php');
        exit;
    }
}
$events = get_events();
$editId = $_GET['edit'] ?? null;
$editEvent = null;
if($editId) {
    foreach($events as $e) {
        if($e['event_id'] == $editId) { $editEvent = $e; break; }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard</title><link rel="stylesheet" href="assets/css/style.css"></head>
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

    <?php if($msg): ?>
      <div class="alert alert-success">
        <span>✅</span> <?=htmlspecialchars($msg)?>
      </div>
    <?php endif; ?>

    <div class="admin-grid">
      <div class="admin-section">
        <div class="section-card">
          <div class="section-header">
            <h2>📝 <?=($editEvent ? 'Edit Event' : 'Create New Event')?></h2>
            <p class="section-subtitle"><?=($editEvent ? 'Update event details' : 'Add a new event for students')?></p>
          </div>
          
          <form method="post" class="admin-form">
            <?php if($editEvent): ?>
              <input type="hidden" name="event_id" value="<?=$editEvent['event_id']?>">
            <?php endif; ?>
            
            <div class="form-group">
              <label for="title">Event Title *</label>
              <input id="title" name="title" type="text" placeholder="e.g., Tech Conference 2025" value="<?=$editEvent['title'] ?? ''?>" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="date">Date *</label>
                <input id="date" name="date" type="date" value="<?=$editEvent['date'] ?? ''?>" required>
              </div>
              <div class="form-group">
                <label for="venue">Venue *</label>
                <input id="venue" name="venue" type="text" placeholder="e.g., Main Hall" value="<?=$editEvent['venue'] ?? ''?>" required>
              </div>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea id="description" name="description" placeholder="Event details, agenda, or requirements..." rows="5"><?=$editEvent['description'] ?? ''?></textarea>
            </div>

            <div class="form-actions">
              <button type="submit" name="<?=($editEvent ? 'edit' : 'create')?>" class="btn btn-primary">
                <?=($editEvent ? '✏️ Update Event' : '➕ Create Event')?>
              </button>
              <?php if($editEvent): ?>
                <a href="admin.php" class="btn btn-secondary">Cancel</a>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>

      <div class="admin-section">
        <div class="section-card">
          <div class="section-header">
            <h2>📊 Event Management</h2>
            <p class="section-subtitle">Total Events: <strong><?=count($events)?></strong></p>
          </div>

          <?php if(count($events) === 0): ?>
            <div class="empty-state">
              <div style="font-size:2rem;margin-bottom:12px">📭</div>
              <p>No events yet. Create one to get started!</p>
            </div>
          <?php else: ?>
            <div class="events-table">
              <?php foreach($events as $e): ?>
                <div class="event-row">
                  <div class="event-info">
                    <div class="event-title-admin"><?=htmlspecialchars($e['title'])?></div>
                    <div class="event-meta-admin">
                      <span>📅 <?=htmlspecialchars($e['date'])?></span>
                      <span>📍 <?=htmlspecialchars($e['venue'] ?? 'TBA')?></span>
                      <span class="event-id">ID: <?=$e['event_id']?></span>
                    </div>
                    <?php if($e['description']): ?>
                      <div class="event-desc-admin"><?=htmlspecialchars(substr($e['description'], 0, 100))?><?=strlen($e['description']) > 100 ? '...' : ''?></div>
                    <?php endif; ?>
                  </div>
                  <div class="event-actions-admin">
                    <a href="admin.php?edit=<?=$e['event_id']?>" class="btn-icon btn-edit" title="Edit event">✏️ Edit</a>
                    <a href="admin_registrations.php?event_id=<?=$e['event_id']?>" class="btn-icon btn-view" title="View registrations">👥 View</a>
                    <form method="post" style="display:contents" onsubmit="return confirm('Delete this event? This cannot be undone.')">
                      <input type="hidden" name="event_id" value="<?=$e['event_id']?>">
                      <button type="submit" name="delete" class="btn-icon btn-delete" title="Delete event">🗑️ Delete</button>
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <footer>&copy; 2025 Student Event Management System — Admin Panel</footer>
  </div>
</body></html>
