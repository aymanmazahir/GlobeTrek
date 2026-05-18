<?php
$_title = 'Admin Dashboard - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$userCount = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$packageCount = $pdo->query('SELECT COUNT(*) FROM packages')->fetchColumn();
$bookingCount = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$inquiryCount = $pdo->query('SELECT COUNT(*) FROM inquiries')->fetchColumn();
$approvedCountStmt = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE status = ?');
$approvedCountStmt->execute(['approved']);
$approvedCount = $approvedCountStmt->fetchColumn();
$pendingCountStmt = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE status = ?');
$pendingCountStmt->execute(['pending']);
$pendingCount = $pendingCountStmt->fetchColumn();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Admin dashboard</span>
    <h2>Administrator overview</h2>
    <p>Monitor system activity, track bookings, and manage users from one central control panel.</p>
  </div>
  <div class="card-grid grid-3">
    <article class="testimonial-card">
      <strong>Users</strong>
      <p class="text-muted">Registered accounts</p>
      <p><?= htmlspecialchars($userCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Packages</strong>
      <p class="text-muted">Active tour packages</p>
      <p><?= htmlspecialchars($packageCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Bookings</strong>
      <p class="text-muted">Total reservations</p>
      <p><?= htmlspecialchars($bookingCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Approved</strong>
      <p class="text-muted">Confirmed bookings</p>
      <p><?= htmlspecialchars($approvedCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Pending</strong>
      <p class="text-muted">Awaiting approval</p>
      <p><?= htmlspecialchars($pendingCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Inquiries</strong>
      <p class="text-muted">Support requests</p>
      <p><?= htmlspecialchars($inquiryCount) ?></p>
    </article>
  </div>
</section>
<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>