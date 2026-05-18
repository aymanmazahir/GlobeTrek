<?php
if(!function_exists('current_user')){
  require_once __DIR__ . '/auth.php';
}
$currentPage = basename($_SERVER['PHP_SELF']);
$adminNav = [
  ['label' => 'Dashboard', 'href' => '/globetrek/admin/dashboard.php', 'key' => 'dashboard.php'],
  ['label' => 'Staff', 'href' => '/globetrek/admin/staff.php', 'key' => 'staff.php'],
  ['label' => 'Users', 'href' => '/globetrek/admin/users.php', 'key' => 'users.php'],
  ['label' => 'Bookings', 'href' => '/globetrek/admin/bookings.php', 'key' => 'bookings.php'],
  ['label' => 'Reports', 'href' => '/globetrek/admin/reports.php', 'key' => 'reports.php'],
  ['label' => 'Security', 'href' => '/globetrek/admin/security.php', 'key' => 'security.php'],
  ['label' => 'Backup', 'href' => '/globetrek/admin/backup.php', 'key' => 'backup.php'],
];
?>
<div class="admin-panel">
  <aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
      <span>GlobeTrek Admin</span>
      <small>Control center</small>
    </div>
    <?php if(!empty($me)): ?>
      <div class="admin-sidebar-user">
        <strong><?= htmlspecialchars($me['name']) ?></strong>
        <span><?= htmlspecialchars(ucfirst($me['role'] ?? 'admin')) ?> access</span>
        <a href="mailto:<?= htmlspecialchars($me['email']) ?>"><?= htmlspecialchars($me['email']) ?></a>
      </div>
    <?php endif ?>
    <nav class="admin-sidebar-nav">
      <?php foreach($adminNav as $item): ?>
        <a href="<?= $item['href'] ?>" class="admin-nav-link<?= $currentPage === $item['key'] ? ' active' : '' ?>"><?= htmlspecialchars($item['label']) ?></a>
      <?php endforeach ?>
    </nav>
    <div class="admin-sidebar-footer">
      <p>Admin controls for system users, bookings, reports, security, and backups.</p>
      <a href="/globetrek/pages/logout.php" class="admin-logout">Logout</a>
    </div>
  </aside>
  <div class="admin-content">
