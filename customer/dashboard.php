<?php
$_title = 'Customer Dashboard - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_login();
$user = current_user();
require_once __DIR__ . '/../includes/db.php';
$sth = $pdo->prepare('SELECT b.id,b.created_at,p.title,p.price FROM bookings b JOIN packages p ON p.id=b.package_id WHERE b.user_id = ? ORDER BY b.created_at DESC');
$sth->execute([$user['id']]);
$bookings = $sth->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Customer dashboard</span>
    <h2>Welcome back, <?= htmlspecialchars($user['name']) ?></h2>
    <p>Review your bookings, check payment status, and explore new travel packages.</p>
  </div>
  <?php if($bookings): ?>
  <div class="page-panel">
    <h3>Booking history</h3>
    <div class="card-grid grid-2" style="margin-top:1rem;">
      <?php foreach($bookings as $booking): ?>
      <article class="testimonial-card">
        <p><strong><?= htmlspecialchars($booking['title']) ?></strong></p>
        <p class="text-muted">Booked on <?= htmlspecialchars(date('M d, Y', strtotime($booking['created_at']))) ?></p>
        <p>Amount: $<?= number_format($booking['price'],2) ?></p>
        <p class="text-muted">Booking ID: <?= htmlspecialchars($booking['id']) ?></p>
      </article>
      <?php endforeach ?>
    </div>
  </div>
  <?php else: ?>
    <div class="page-alert">You have no bookings yet. Explore packages and make your first reservation.</div>
  <?php endif ?>
  <a class="button" href="/globetrek/pages/packages.php">Browse packages</a>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>