<?php
require_once __DIR__.'/../src/db.php';
require_once __DIR__.'/../src/auth.php';
$error = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';

  // Basic server-side validation
  if(!$name || !$email || !$pass){
    $error = 'All fields are required.';
  } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = 'Enter a valid email address.';
  } elseif(strlen($pass) < 6){
    $error = 'Password must be at least 6 characters.';
  } else {
    $pdo = getPDO();
    // Check duplicate email
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if($stmt->fetchColumn() > 0){
      $error = 'An account with that email already exists.';
    } else {
      $h = password_hash($pass, PASSWORD_DEFAULT);
      try{
        $stmt = $pdo->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)');
        $stmt->execute([$name,$email,$h]);
        header('Location: login.php'); exit;
      }catch(PDOException $ex){
        // Generic error message
        $error = 'Could not create account. Please try again later.';
      }
    }
  }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Sign up</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
  <div class="container">
    <header>
      <h1>🎓 Student Events</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
      </nav>
    </header>

    <div class="auth-container">
      <div class="auth-card">
        <h1>Create Account</h1>
        <?php if($error): ?><div class="auth-error"><?=htmlspecialchars($error)?></div><?php endif; ?>
        <form method="post" id="signup">
          <div class="form-group">
            <label for="name">Full Name</label>
            <input id="name" name="name" required placeholder="John Doe">
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" name="email" type="email" required placeholder="your@email.com">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required placeholder="••••••••" minlength="6">
            <small style="color:var(--muted);font-size:0.85rem;display:block;margin-top:4px">Minimum 6 characters</small>
          </div>
          <button class="btn" style="width:100%;margin-top:12px">Create Account</button>
        </form>
        <div class="auth-footer">
          <p>Already have an account?</p>
          <a href="login.php">Sign in here</a>
        </div>
      </div>
    </div>

    <footer>&copy; 2025 Student Event Management System</footer>
  </div>
  <script src="assets/js/app.js"></script>
</body></html>
