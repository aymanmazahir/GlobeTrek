<?php
$_title = 'Admin Reports - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$totalSales = $pdo->query('SELECT SUM(total_price) FROM bookings WHERE status = "approved"')->fetchColumn() ?: 0;
$customerStmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
$customerStmt->execute(['customer']);
$customerCount = $customerStmt->fetchColumn() ?: 0;
$paymentStmt = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE status = ?');
$paymentStmt->execute(['approved']);
$paymentCount = $paymentStmt->fetchColumn() ?: 0;
$packageReport = $pdo->query('SELECT p.title, COUNT(b.id) AS total FROM packages p LEFT JOIN bookings b ON b.package_id = p.id GROUP BY p.id ORDER BY total DESC LIMIT 5')->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Analytics reports</span>
    <h2>Sales and customer reports</h2>
    <p>View revenue, customer growth, and your top-performing packages in one place.</p>
  </div>
  <div class="card-grid grid-3">
    <article class="hero-card" style="background:rgba(33,141,83,0.1); border-color:rgba(33,141,83,0.2);">
      <strong style="color:var(--success);">Total sales</strong>
      <p class="text-muted">Revenue from bookings</p>
      <p style="font-size:1.8rem; font-weight:bold; color:var(--text);">$<?= number_format($totalSales, 2) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(0,167,255,0.1); border-color:rgba(0,167,255,0.2);">
      <strong style="color:var(--accent-dark);">Customers</strong>
      <p class="text-muted">Registered customers</p>
      <p style="font-size:1.8rem; font-weight:bold; color:var(--text);"><?= htmlspecialchars($customerCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(255,138,43,0.1); border-color:rgba(255,138,43,0.2);">
      <strong style="color:var(--warning);">Approved bookings</strong>
      <p class="text-muted">Completed reservations</p>
      <p style="font-size:1.8rem; font-weight:bold; color:var(--text);"><?= htmlspecialchars($paymentCount) ?></p>
    </article>
  </div>
  <div class="page-panel" style="margin-top:2rem;">
    <h3>Top packages</h3>
    <table class="admin-table">
      <thead><tr><th>Package</th><th>Bookings</th></tr></thead>
      <tbody>
        <?php foreach($packageReport as $row): ?>
          <tr><td><?= htmlspecialchars($row['title']) ?></td><td><?= htmlspecialchars($row['total']) ?></td></tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</section>
<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>