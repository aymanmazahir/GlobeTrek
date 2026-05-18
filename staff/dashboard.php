<?php
$_title = 'Staff Dashboard - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('staff');
require_once __DIR__ . '/../includes/db.php';

$packageCount = $pdo->query('SELECT COUNT(*) FROM packages WHERE status="active"')->fetchColumn();
$bookingCount = $pdo->query('SELECT COUNT(*) FROM bookings WHERE status="pending"')->fetchColumn();
$inquiryCount = $pdo->query('SELECT COUNT(*) FROM inquiries WHERE status="unread"')->fetchColumn();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Staff dashboard</span>
    <h2>Staff Control Panel</h2>
    <p>Manage travel packages, confirm customer bookings, and handle operations.</p>
  </div>
  
  <div class="card-grid grid-3">
    <article class="hero-card" style="background:rgba(33,141,83,0.1); border-color:rgba(33,141,83,0.2);">
      <h3 style="color:var(--success);">Active Packages</h3>
      <p class="text-muted">Currently available tours</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text);"><?= htmlspecialchars($packageCount) ?></p>
      <div style="margin-top:1rem;">
          <a class="button small" href="/globetrek/staff/packages.php">Manage Packages</a>
      </div>
    </article>
    
    <article class="hero-card" style="background:rgba(255,138,43,0.1); border-color:rgba(255,138,43,0.2);">
      <h3 style="color:var(--warning);">Pending Bookings</h3>
      <p class="text-muted">Awaiting confirmation</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text);"><?= htmlspecialchars($bookingCount) ?></p>
      <div style="margin-top:1rem;">
          <a class="button small" style="background:var(--warning);" href="/globetrek/staff/bookings.php">Confirm Bookings</a>
      </div>
    </article>
    
    <article class="hero-card" style="background:rgba(0,167,255,0.1); border-color:rgba(0,167,255,0.2);">
      <h3 style="color:var(--accent-dark);">Unread Inquiries</h3>
      <p class="text-muted">Customer messages</p>
      <p style="font-size:2rem; font-weight:bold; color:var(--text);"><?= htmlspecialchars($inquiryCount) ?></p>
      <div style="margin-top:1rem;">
          <a class="button small" style="background:var(--accent-dark);" href="/globetrek/staff/inquiries.php">View Inquiries</a>
      </div>
    </article>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>