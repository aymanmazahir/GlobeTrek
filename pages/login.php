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


  <form method="post" action="/globetrek/api/login.php">
    <div class="field"><label>Email</label><input name="email" type="email" required></div>
    <div class="field"><label>Password</label><input name="password" type="password" required></div>
    <div class="field"><button type="submit">Login</button></div>
  </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>