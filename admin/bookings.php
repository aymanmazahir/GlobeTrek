<?php
$_title = 'Admin Bookings - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$message = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['action']) && isset($_POST['booking_id'])){
    $bookingId = (int) $_POST['booking_id'];
    if($_POST['action'] === 'approve'){
      $sth = $pdo->prepare('UPDATE bookings SET status = ? WHERE id = ?');
      $sth->execute(['approved', $bookingId]);
      $message = 'Booking approved successfully.';
    } elseif($_POST['action'] === 'cancel'){
      $sth = $pdo->prepare('UPDATE bookings SET status = ? WHERE id = ?');
      $sth->execute(['cancelled', $bookingId]);
      $message = 'Booking cancelled successfully.';
    }
  }
}

$packages = $pdo->query('SELECT id,title FROM packages ORDER BY title')->fetchAll();
$bookings = $pdo->query('
  SELECT b.*, c.full_name AS name, u.email, p.title AS package_title 
  FROM bookings b 
  JOIN customers c ON b.customer_id = c.id 
  JOIN users u ON c.user_id = u.id 
  LEFT JOIN packages p ON b.package_id = p.id 
  ORDER BY b.created_at DESC
')->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="admin-action-row" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <span class="section-label">Booking management</span>
      <h2>Monitor customer bookings</h2>
      <p>Review customer reservations, track travel details, and approve or cancel requests.</p>
    </div>
  </div>
  
  <?php if($message): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(window.showToast) window.showToast(<?= json_encode($message) ?>, 'success');
        });
    </script>
  <?php endif ?>
  
  <div class="page-panel">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Email</th>
          <th>Package</th>
          <th>Travel Date</th>
          <th>Guests</th>
          <th>Total Price</th>
          <th>Status</th>
          <th>Created</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($bookings as $booking): ?>
          <tr>
            <td>#<?= htmlspecialchars($booking['id']) ?></td>
            <td><?= htmlspecialchars($booking['name']) ?></td>
            <td><?= htmlspecialchars($booking['email']) ?></td>
            <td><?= htmlspecialchars($booking['package_title'] ?: 'Unknown') ?></td>
            <td><?= htmlspecialchars($booking['travel_date']) ?></td>
            <td><?= htmlspecialchars($booking['guests_count']) ?></td>
            <td>$<?= number_format($booking['total_price'], 2) ?></td>
            <td><span class="status-pill status-<?= htmlspecialchars($booking['status'] ?: 'pending') ?>"><?= htmlspecialchars($booking['status'] ?: 'pending') ?></span></td>
            <td><?= htmlspecialchars($booking['created_at']) ?></td>
            <td>
              <button class="button small ghost" data-modal-open="#modalViewBooking-<?= htmlspecialchars($booking['id']) ?>" data-modal-title="Booking Details">View Details</button>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</section>

<!-- View Booking Modal Templates -->
<?php foreach($bookings as $booking): ?>
<template id="modalViewBooking-<?= htmlspecialchars($booking['id']) ?>">
  <div style="font-size:0.95rem; line-height:1.6; color:var(--text);">
    <div style="margin-bottom:1.5rem; background:rgba(0,167,255,0.05); padding:1rem; border-radius:12px; border:1px solid rgba(0,167,255,0.1);">
      <h3 style="margin:0 0 0.5rem 0; font-size:1.15rem; color:var(--accent-dark);"><?= htmlspecialchars($booking['package_title'] ?: 'Unknown Package') ?></h3>
      <p style="margin:0;"><strong>Booking ID:</strong> #<?= htmlspecialchars($booking['id']) ?></p>
      <p style="margin:0;"><strong>Status:</strong> <span class="status-pill status-<?= htmlspecialchars($booking['status']) ?>" style="font-size:0.8rem;"><?= htmlspecialchars($booking['status']) ?></span></p>
    </div>
    
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">
      <div>
        <p style="margin:0 0 0.25rem 0; color:var(--text-muted); font-size:0.85rem;">CUSTOMER NAME</p>
        <p style="margin:0; font-weight:600;"><?= htmlspecialchars($booking['name']) ?></p>
      </div>
      <div>
        <p style="margin:0 0 0.25rem 0; color:var(--text-muted); font-size:0.85rem;">CUSTOMER EMAIL</p>
        <p style="margin:0; font-weight:600;"><?= htmlspecialchars($booking['email']) ?></p>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem; border-top:1px solid rgba(0,0,0,0.05); padding-top:1rem;">
      <div>
        <p style="margin:0 0 0.25rem 0; color:var(--text-muted); font-size:0.85rem;">TRAVEL DATE</p>
        <p style="margin:0; font-weight:600;"><?= htmlspecialchars($booking['travel_date']) ?></p>
      </div>
      <div>
        <p style="margin:0 0 0.25rem 0; color:var(--text-muted); font-size:0.85rem;">GUESTS COUNT</p>
        <p style="margin:0; font-weight:600;"><?= htmlspecialchars($booking['guests_count']) ?> Guest(s)</p>
      </div>
    </div>

    <div style="margin-bottom:1.5rem; border-top:1px solid rgba(0,0,0,0.05); padding-top:1rem;">
      <p style="margin:0 0 0.25rem 0; color:var(--text-muted); font-size:0.85rem;">TOTAL BOOKING PRICE</p>
      <p style="margin:0; font-size:1.3rem; font-weight:700; color:var(--success);">$<?= number_format($booking['total_price'], 2) ?></p>
    </div>

    <?php if($booking['status'] === 'pending'): ?>
      <div style="border-top:1px solid rgba(0,0,0,0.05); padding-top:1.5rem; display:flex; gap:1rem;">
        <form method="post" style="margin:0; flex:1;">
          <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
          <button type="submit" name="action" value="approve" class="button" style="width:100%; background:var(--success);">Approve Reservation</button>
        </form>
        <form method="post" style="margin:0; flex:1;">
          <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
          <button type="submit" name="action" value="cancel" class="button ghost" style="width:100%; color:var(--warning); border-color:var(--warning); background:transparent;" onclick="return confirm('Cancel this reservation?');">Cancel Reservation</button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</template>
<?php endforeach ?>

<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>