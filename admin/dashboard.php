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
    <article class="hero-card" style="background:rgba(0,167,255,0.05); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark);">Users</h3>
      <p class="text-muted">Registered accounts</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($userCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(0,167,255,0.05); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark);">Packages</h3>
      <p class="text-muted">Active tour packages</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($packageCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(0,167,255,0.05); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark);">Total Bookings</h3>
      <p class="text-muted">All reservations</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($bookingCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(33,141,83,0.05); border:1px solid rgba(33,141,83,0.15);">
      <h3 style="color:var(--success);">Approved</h3>
      <p class="text-muted">Confirmed bookings</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($approvedCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(255,138,43,0.05); border:1px solid rgba(255,138,43,0.15);">
      <h3 style="color:var(--warning);">Pending</h3>
      <p class="text-muted">Awaiting approval</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($pendingCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(0,167,255,0.05); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark);">Inquiries</h3>
      <p class="text-muted">Support requests</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($inquiryCount) ?></p>
    </article>
  </div>
</section>
<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>