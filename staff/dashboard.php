<?php
$_title = 'Staff Dashboard - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('staff');
require_once __DIR__ . '/../includes/db.php';
$packageCount = $pdo->query('SELECT COUNT(*) FROM packages')->fetchColumn();
$bookingCount = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$inquiryCount = $pdo->query('SELECT COUNT(*) FROM inquiries')->fetchColumn();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Staff dashboard</span>
    <h2>Staff control panel</h2>
    <p>Manage packages, review bookings, and respond to customer inquiries from one place.</p>
  </div>
  <div class="card-grid grid-3">
    <article class="testimonial-card">
      <strong>Packages</strong>
      <p class="text-muted">Total packages available</p>
      <p><?= htmlspecialchars($packageCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Bookings</strong>
      <p class="text-muted">Total reservations</p>
      <p><?= htmlspecialchars($bookingCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Inquiries</strong>
      <p class="text-muted">Pending customer messages</p>
      <p><?= htmlspecialchars($inquiryCount) ?></p>
    </article>
  </div>
  <div style="margin-top:1.5rem;">
    <a class="button" href="/globetrek/staff/packages.php">Manage packages</a>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>