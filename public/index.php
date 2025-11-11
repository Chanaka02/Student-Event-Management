<?php
require_once __DIR__ . '/../src/auth.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Student Event Management</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>🎓 Student Events</h1>
      <nav>
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

    <main>
      <section class="hero">
        <div class="hero-content">
          <h2 class="event-title">Discover & Manage Student Events</h2>
          <p class="muted">Connect with peers, attend workshops, and build your network with university events.</p>
          <div class="panel">
            <div class="muted" style="font-size:1rem;font-weight:600">Join thousands of students exploring opportunities</div>
            <div class="actions">
              <a class="btn" href="events.php">Browse Events</a>
              <?php if(!current_user()): ?><a class="btn secondary" href="signup.php">Get Started</a><?php endif; ?>
            </div>
          </div>
        </div>
      </section>

      <section class="section">
        <h2>Why Join Events?</h2>
        <div class="features">
          <div class="feature">
            <strong>📚 Learn & Grow</strong>
            <p>Attend workshops and seminars from industry experts and faculty.</p>
          </div>
          <div class="feature">
            <strong>🤝 Network</strong>
            <p>Meet fellow students, build friendships, and expand your professional circle.</p>
          </div>
          <div class="feature">
            <strong>💼 Opportunities</strong>
            <p>Discover internships, career talks, and mentorship programs.</p>
          </div>
          <div class="feature">
            <strong>🏆 Achievement</strong>
            <p>Earn certificates and gain valuable experience for your resume.</p>
          </div>
        </div>
      </section>

      <section class="section">
        <h2>Quick Stats</h2>
        <div class="stats">
          <div class="stat-card">
            <strong>150+</strong>
            <p>Events organized</p>
          </div>
          <div class="stat-card">
            <strong>5000+</strong>
            <p>Active students</p>
          </div>
          <div class="stat-card">
            <strong>50+</strong>
            <p>Partner organizations</p>
          </div>
          <div class="stat-card">
            <strong>24/7</strong>
            <p>Event updates</p>
          </div>
        </div>
      </section>

      <section class="section">
        <h2>Upcoming Featured Events</h2>
        <div class="card">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <div>
              <div class="event-title">Intro to Web Development</div>
              <div class="meta">
                <span>📅 Dec 1, 2025</span>
                <span>📍 Auditorium</span>
              </div>
              <div class="description">Learn HTML, CSS, and JavaScript from scratch in this interactive workshop. Perfect for beginners!</div>
              <div class="panel">
                <div class="muted">A great way to start your web dev journey</div>
                <a class="btn" href="events.php">View Event</a>
              </div>
            </div>
            <div style="background:linear-gradient(135deg,#667eea,#764ba2);border-radius:var(--radius);padding:20px;color:#fff;display:flex;align-items:center;justify-content:center">
              <div style="text-align:center">
                <div style="font-size:2.5rem;margin-bottom:8px">🌐</div>
                <div style="font-weight:600">Web Development</div>
                <div style="font-size:0.9rem;margin-top:6px;opacity:0.9">Beginner-friendly workshop</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="section">
        <h2>How It Works</h2>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px">
          <div style="text-align:center">
            <div style="background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.8rem">1</div>
            <strong style="display:block;color:var(--primary);margin-bottom:6px">Sign Up</strong>
            <p style="margin:0;color:var(--muted);font-size:0.9rem">Create your free account in seconds</p>
          </div>
          <div style="text-align:center">
            <div style="background:linear-gradient(135deg,#f093fb,#f5576c);color:#fff;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.8rem">2</div>
            <strong style="display:block;color:var(--primary);margin-bottom:6px">Browse</strong>
            <p style="margin:0;color:var(--muted);font-size:0.9rem">Explore upcoming events and seminars</p>
          </div>
          <div style="text-align:center">
            <div style="background:linear-gradient(135deg,#4facfe,#00f2fe);color:#fff;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.8rem">3</div>
            <strong style="display:block;color:var(--primary);margin-bottom:6px">Register</strong>
            <p style="margin:0;color:var(--muted);font-size:0.9rem">Register and join the event</p>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="card" style="background:linear-gradient(135deg,rgba(37,99,235,0.1),rgba(124,58,237,0.1));text-align:center;padding:32px">
          <h3 style="margin-top:0;color:var(--primary);font-size:1.6rem">Ready to explore?</h3>
          <p style="color:var(--muted);margin-bottom:20px">Join our community and never miss an amazing event.</p>
          <div class="actions" style="justify-content:center;gap:12px">
            <a class="btn" href="events.php">Browse All Events</a>
            <?php if(!current_user()): ?><a class="btn secondary" href="signup.php">Create Account</a><?php endif; ?>
          </div>
        </div>
      </section>
    </main>

    <footer>&copy; 2025 Student Event Management System. All rights reserved.</footer>
  </div>
</body>
</html>
