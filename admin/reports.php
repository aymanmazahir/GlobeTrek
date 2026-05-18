<?php
$_title = 'Admin Reports - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$totalSales = $pdo->query('SELECT SUM(p.price) FROM bookings b JOIN packages p ON b.package_id = p.id')->fetchColumn() ?: 0;
$customerStmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
$customerStmt->execute(['customer']);
$customerCount = $customerStmt->fetchColumn() ?: 0;
$paymentStmt = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE status = ?');
$paymentStmt->execute(['approved']);
$paymentCount = $paymentStmt->fetchColumn() ?: 0;
$packageReport = $pdo->query('SELECT p.title, COUNT(*) AS total FROM bookings b JOIN packages p ON b.package_id = p.id GROUP BY p.title ORDER BY total DESC LIMIT 5')->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Analytics reports</span>
    <h2>Sales and customer reports</h2>
    <p>View revenue, customer growth, and your top-performing packages in one place.</p>
  </div>
  <div class="card-grid grid-3">
    <article class="testimonial-card">
      <strong>Total sales</strong>
      <p class="text-muted">Revenue from bookings</p>
      <p>$<?= number_format($totalSales, 2) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Customers</strong>
      <p class="text-muted">Registered customers</p>
      <p><?= htmlspecialchars($customerCount) ?></p>
    </article>
    <article class="testimonial-card">
      <strong>Approved bookings</strong>
      <p class="text-muted">Completed payments</p>
      <p><?= htmlspecialchars($paymentCount) ?></p>
    </article>
  </div>
  <div class="page-panel" style="margin-top:1.5rem;">
    <h3>Top packages</h3>
    <table class="admin-table">
      <thead><tr><th>Package</th><th>Booked</th></tr></thead>
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