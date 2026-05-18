<?php
$_title = 'Login - GlobeTrek';
include __DIR__ . '/../includes/header.php';
$error = isset($_GET['error']);
$registered = isset($_GET['registered']);
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <h2>Login</h2>
    <p>Access your GlobeTrek account to manage bookings, payments, and travel plans.</p>
  </div>
  <?php if($registered): ?>
    <div class="page-alert">Registration successful. Please log in.</div>
  <?php endif ?>
  <?php if($error): ?>
    <div class="page-alert">Invalid credentials. Please try again.</div>
  <?php endif ?>
  <div class="page-alert" style="background:linear-gradient(135deg, rgba(0,167,255,.14), rgba(255,138,43,.14));border-color:rgba(0,167,255,.24);color:var(--text);">
    Use the admin preview login to check the admin dashboard:<br>
    <strong>Email:</strong> admin@globetrek.com<br>
    <strong>Password:</strong> Admin@123
  </div>
  <form method="post" action="/globetrek/api/login.php">
    <div class="field"><label>Email</label><input name="email" type="email" required></div>
    <div class="field"><label>Password</label><input name="password" type="password" required></div>
    <div class="field"><button type="submit">Login</button></div>
  </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>