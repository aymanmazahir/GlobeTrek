<?php
$_title = 'Admin Bookings - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$message = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['action'])){
    if($_POST['action'] === 'add_booking'){
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $packageId = (int) ($_POST['package_id'] ?? 0);
      $status = $_POST['status'] ?? 'pending';
      if($name && $email && $packageId){
        $pdo->prepare('INSERT INTO bookings (name,email,package_id,status,created_at) VALUES (?,?,?,?,NOW())')
            ->execute([$name, $email, $packageId, $status]);
        $message = 'Booking added successfully.';
      } else {
        $message = 'Please complete the booking form.';
      }
    } elseif($_POST['action'] === 'update_booking' && isset($_POST['booking_id'])){
      $bookingId = (int) $_POST['booking_id'];
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $packageId = (int) ($_POST['package_id'] ?? 0);
      $status = $_POST['status'] ?? 'pending';
      if($name && $email && $packageId){
        $pdo->prepare('UPDATE bookings SET name = ?, email = ?, package_id = ?, status = ? WHERE id = ?')
            ->execute([$name, $email, $packageId, $status, $bookingId]);
        $message = 'Booking updated successfully.';
      } else {
        $message = 'Please complete the booking details.';
      }
    } elseif(isset($_POST['booking_id'])){
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
}

$packages = $pdo->query('SELECT id,title FROM packages ORDER BY title')->fetchAll();
$bookings = $pdo->query('SELECT b.*, p.title AS package_title FROM bookings b LEFT JOIN packages p ON b.package_id = p.id ORDER BY b.created_at DESC')->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="admin-action-row">
    <div>
      <span class="section-label">Booking management</span>
      <h2>Monitor and approve bookings</h2>
      <p>Review recent reservations, confirm approvals, and manage bookings from a single table.</p>
    </div>
    <button class="button" data-modal-open="#modalAddBooking" data-modal-title="Add booking">Add booking</button>
  </div>
  <?php if($message): ?>
    <div class="page-alert"><?= htmlspecialchars($message) ?></div>
  <?php endif ?>
  <div class="page-panel">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Email</th>
          <th>Package</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($bookings as $booking): ?>
          <tr>
            <td><?= htmlspecialchars($booking['id']) ?></td>
            <td><?= htmlspecialchars($booking['name']) ?></td>
            <td><?= htmlspecialchars($booking['email']) ?></td>
            <td><?= htmlspecialchars($booking['package_title'] ?: 'Unknown') ?></td>
            <td><span class="status-pill status-<?= htmlspecialchars($booking['status'] ?: 'pending') ?>"><?= htmlspecialchars($booking['status'] ?: 'pending') ?></span></td>
            <td><?= htmlspecialchars($booking['created_at']) ?></td>
            <td>
              <button class="button small ghost" data-modal-open="#modalEditBooking-<?= htmlspecialchars($booking['id']) ?>" data-modal-title="Manage booking">Manage</button>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</section>

<template id="modalAddBooking">
  <form method="post">
    <input type="hidden" name="action" value="add_booking">
    <div class="field"><label>Customer name</label><input name="name" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" required></div>
    <div class="field"><label>Package</label><select name="package_id" required>
      <?php foreach($packages as $package): ?>
        <option value="<?= htmlspecialchars($package['id']) ?>"><?= htmlspecialchars($package['title']) ?></option>
      <?php endforeach ?>
    </select></div>
    <div class="field"><label>Status</label><select name="status"><option value="pending">Pending</option><option value="approved">Approved</option><option value="cancelled">Cancelled</option></select></div>
    <div class="field"><button class="button" type="submit">Add booking</button></div>
  </form>
</template>

<?php foreach($bookings as $booking): ?>
<template id="modalEditBooking-<?= htmlspecialchars($booking['id']) ?>">
  <form method="post">
    <input type="hidden" name="action" value="update_booking">
    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
    <div class="field"><label>Customer name</label><input name="name" value="<?= htmlspecialchars($booking['name']) ?>" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" value="<?= htmlspecialchars($booking['email']) ?>" required></div>
    <div class="field"><label>Package</label><select name="package_id" required>
      <?php foreach($packages as $package): ?>
        <option value="<?= htmlspecialchars($package['id']) ?>"<?= $package['id'] == $booking['package_id'] ? ' selected' : '' ?>><?= htmlspecialchars($package['title']) ?></option>
      <?php endforeach ?>
    </select></div>
    <div class="field"><label>Status</label><select name="status"><option value="pending"<?= $booking['status'] === 'pending' ? ' selected' : '' ?>>Pending</option><option value="approved"<?= $booking['status'] === 'approved' ? ' selected' : '' ?>>Approved</option><option value="cancelled"<?= $booking['status'] === 'cancelled' ? ' selected' : '' ?>>Cancelled</option></select></div>
    <div class="field"><button class="button" type="submit">Save changes</button></div>
  </form>
  <form method="post" style="margin-top:1rem; display:flex; gap:.75rem; flex-wrap:wrap; align-items:center;">
    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
    <button class="button small" type="submit" name="action" value="approve">Approve</button>
    <button class="button small ghost" type="submit" name="action" value="cancel">Cancel</button>
  </form>
</template>
<?php endforeach ?>

<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>