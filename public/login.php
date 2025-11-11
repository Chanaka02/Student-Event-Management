<?php
require_once __DIR__.'/../src/auth.php';
if(isset($_GET['logout'])){ logout(); header('Location: index.php'); exit; }
$error = '';
$redirect_msg = $_SESSION['redirect_message'] ?? '';
unset($_SESSION['redirect_message']);
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!login_user($_POST['email'], $_POST['password'])){
        $error = 'Invalid credentials';
  } else { header('Location: index.php'); exit; }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
  <div class="container">
    <header>
      <h1>🎓 Student Events</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="signup.php">Sign up</a>
      </nav>
    </header>

    <div class="auth-container">
      <div class="auth-card">
        <h1>Welcome Back</h1>
        <?php if($redirect_msg): ?><div style="background:#dbeafe;color:#1e40af;padding:12px;border-radius:8px;margin-bottom:16px;border-left:4px solid #3b82f6"><?=htmlspecialchars($redirect_msg)?></div><?php endif; ?>
        <?php if($error): ?><div class="auth-error"><?=htmlspecialchars($error)?></div><?php endif; ?>
        <form method="post">
          <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" name="email" type="email" required placeholder="your@email.com">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required placeholder="••••••••">
          </div>
          <button class="btn" style="width:100%;margin-top:12px">Sign In</button>
        </form>
        <div class="auth-footer">
          <p>Don't have an account?</p>
          <a href="signup.php">Create one now</a>
        </div>
      </div>
    </div>

    <footer>&copy; 2025 Student Event Management System</footer>
  </div>
</body></html>
