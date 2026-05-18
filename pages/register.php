<?php
$_title = 'Register - GlobeTrek';
include __DIR__ . '/../includes/header.php';
$error = isset($_GET['error']);
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <h2>Create your account</h2>
    <p>Register now to book your next trip, save your details, and track your travel plans.</p>
  </div>
  <?php if($error): ?>
    <div class="page-alert">Please complete all fields to register.</div>
  <?php endif ?>
  <form method="post" action="/globetrek/api/register.php">
    <div class="field"><label>Name</label><input name="name" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" required></div>
    <div class="field"><label>Password</label><input name="password" type="password" required></div>
    <div class="field"><button type="submit">Register</button></div>
  </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>