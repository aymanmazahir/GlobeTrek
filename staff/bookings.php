<?php
$_title = 'Manage Bookings - Staff - GlobeTrek';
include __DIR__ . '/../includes/header.php';
require_role('staff');
require_once __DIR__ . '/../includes/db.php';

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 'approved' : 'cancelled';
    
    $stmt = $pdo->prepare('UPDATE bookings SET status = ? WHERE id = ?');
    $stmt->execute([$status, $booking_id]);
    header('Location: /globetrek/staff/bookings.php?updated=1');
    exit;
}

$sth = $pdo->query('
    SELECT b.id, b.travel_date, b.guests_count, b.status, b.total_price, b.created_at, 
           c.full_name, c.phone, p.title 
    FROM bookings b 
    JOIN customers c ON c.id = b.customer_id
    JOIN packages p ON p.id = b.package_id
    ORDER BY b.created_at DESC
');
$bookings = $sth->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Staff</span>
    <h2>Manage Bookings</h2>
    <p>Review customer reservations and update their status.</p>
  </div>
  


  <div class="page-panel">
    <div style="overflow-x:auto;">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Package</th>
            <th>Travel Date</th>
            <th>Guests</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($bookings as $b): ?>
          <tr>
            <td>#<?= htmlspecialchars($b['id']) ?></td>
            <td>
              <strong><?= htmlspecialchars($b['full_name']) ?></strong><br>
              <small class="text-muted"><?= htmlspecialchars($b['phone']) ?></small>
            </td>
            <td><?= htmlspecialchars($b['title']) ?></td>
            <td><?= htmlspecialchars(date('M d, Y', strtotime($b['travel_date']))) ?></td>
            <td><?= htmlspecialchars($b['guests_count']) ?></td>
            <td>$<?= number_format($b['total_price'], 2) ?></td>
            <td>
              <span class="status-pill status-<?= htmlspecialchars($b['status']) ?>">
                <?= ucfirst(htmlspecialchars($b['status'])) ?>
              </span>
            </td>
            <td>
              <?php if($b['status'] === 'pending'): ?>
              <form method="post" action="" style="display:flex;gap:0.5rem;">
                <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                <button type="submit" name="action" value="approve" class="button small" style="background:var(--success);">Approve</button>
                <button type="submit" name="action" value="cancel" class="button small" style="background:var(--warning);" onclick="return confirm('Cancel this booking?');">Cancel</button>
              </form>
              <?php else: ?>
              <span class="text-muted">No actions</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if(!$bookings): ?>
          <tr><td colspan="8" style="text-align:center;">No bookings found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>