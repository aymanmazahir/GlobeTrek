<?php
$_title = 'Admin Security - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$message = null;
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset_admin_password'){
  $currentPassword = $_POST['current_password'] ?? '';
  $newPassword = $_POST['new_password'] ?? '';
  $confirmPassword = $_POST['confirm_password'] ?? '';
  if(!$currentPassword || !$newPassword || !$confirmPassword){
    $message = 'Please fill every password field.';
  } elseif($newPassword !== $confirmPassword){
    $message = 'New password and confirmation do not match.';
  } else {
    $adminEmail = 'admin@globetrek.com';
    $user = $pdo->prepare('SELECT password_hash FROM users WHERE email = ? LIMIT 1');
    $user->execute([$adminEmail]);
    $existing = $user->fetch();
    if($existing && password_verify($currentPassword, $existing['password_hash'])){
      $pdo->prepare('UPDATE users SET password_hash = ? WHERE email = ?')->execute([password_hash($newPassword, PASSWORD_BCRYPT), $adminEmail]);
      $message = 'Admin password has been updated.';
    } else {
      $message = 'Current password is incorrect.';
    }
  }
}

$stmtCustomer = $pdo->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
$stmtCustomer->execute(['customer']);
$customerCount = $stmtCustomer->fetchColumn();
$stmtStaff = $pdo->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
$stmtStaff->execute(['staff']);
$staffCount = $stmtStaff->fetchColumn();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Security management</span>
    <h2>System security controls</h2>
    <p>Manage administrator access and view a quick summary of roles within the system.</p>
  </div>
  <?php if($message): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(window.showToast) window.showToast(<?= json_encode($message) ?>, 'success');
        });
    </script>
  <?php endif ?>
  <div class="card-grid grid-2">
    <article class="testimonial-card">
      <strong>Customer accounts</strong>
      <p class="text-muted">Current customer users</p>
      <p><?= htmlspecialchars($customerCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Staff accounts</strong>
      <p class="text-muted">Current staff users</p>
      <p><?= htmlspecialchars($staffCount) ?></p>
    </article>
  </div>
  <div class="page-panel" style="margin-top:1.5rem;">
    <h3>Reset admin password</h3>
    <form method="post">
      <input type="hidden" name="action" value="reset_admin_password">
      <div class="field"><label>Current password</label><input name="current_password" type="password" required></div>
      <div class="field"><label>New password</label><input name="new_password" type="password" required></div>
      <div class="field"><label>Confirm new password</label><input name="confirm_password" type="password" required></div>
      <div class="field"><button class="button" type="submit">Update password</button></div>
    </form>
  </div>
</section>
<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>