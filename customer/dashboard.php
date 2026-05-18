<?php
$_title = 'Customer Dashboard - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_login();
$user = current_user();

if ($user['role'] !== 'customer') {
    header('Location: /globetrek/pages/index.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';

// Fetch customer ID
$stmt = $pdo->prepare('SELECT id, full_name, phone, address FROM customers WHERE user_id = ?');
$stmt->execute([$user['id']]);
$customer = $stmt->fetch();

if (!$customer) {
    echo "<div class='page-alert'>Error loading customer profile.</div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Handle Cancel Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];
    $cancelStmt = $pdo->prepare('UPDATE bookings SET status = "cancelled" WHERE id = ? AND customer_id = ?');
    $cancelStmt->execute([$booking_id, $customer['id']]);
    header("Location: /globetrek/customer/dashboard.php?cancelled=1");
    exit;
}

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $updateStmt = $pdo->prepare('UPDATE customers SET full_name = ?, phone = ?, address = ? WHERE id = ?');
    $updateStmt->execute([$full_name, $phone, $address, $customer['id']]);
    header("Location: /globetrek/customer/dashboard.php?updated=1");
    exit;
}

$sth = $pdo->prepare('
    SELECT b.id, b.travel_date, b.guests_count, b.status, b.total_price, b.created_at, p.title, p.destination, p.image_url 
    FROM bookings b 
    JOIN packages p ON p.id = b.package_id 
    WHERE b.customer_id = ? 
    ORDER BY b.created_at DESC
');
$sth->execute([$customer['id']]);
$bookings = $sth->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Customer dashboard</span>
    <h2>Welcome back, <?= htmlspecialchars($customer['full_name']) ?></h2>
    <p>Review your bookings, manage your account, and explore new travel packages.</p>
  </div>
  


  <div class="card-grid grid-2">
    <!-- Booking History -->
    <div class="page-panel" style="margin-bottom:0;">
      <h3>My Bookings</h3>
      <?php if($bookings): ?>
        <div style="display:flex; flex-direction:column; gap:1rem; margin-top:1rem;">
          <?php foreach($bookings as $booking): ?>
          <article class="hero-card" style="background:rgba(0,167,255,0.05); border:1px solid rgba(0,167,255,0.15); border-radius: 20px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
              <div>
                <h4 style="margin:0 0 0.25rem;color:var(--text);"><?= htmlspecialchars($booking['title']) ?> (<?= htmlspecialchars($booking['destination']) ?>)</h4>
                <p class="text-muted" style="margin:0;font-size:0.9rem;">Travel Date: <?= htmlspecialchars(date('M d, Y', strtotime($booking['travel_date']))) ?> | Guests: <?= $booking['guests_count'] ?></p>
                <p style="margin:0.5rem 0 0; font-weight:bold;">Total: $<?= number_format($booking['total_price'], 2) ?></p>
              </div>
              <span class="status-pill status-<?= htmlspecialchars($booking['status']) ?>">
                <?= ucfirst(htmlspecialchars($booking['status'])) ?>
              </span>
            </div>
            
            <?php if($booking['status'] === 'pending'): ?>
            <div style="margin-top:1rem; border-top:1px solid rgba(0,0,0,0.05); padding-top:1rem;">
                <form method="post" action="" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                    <button type="submit" name="cancel_booking" class="button ghost" style="color:var(--warning); border-color:var(--warning);">Cancel Booking</button>
                </form>
            </div>
            <?php endif; ?>
          </article>
          <?php endforeach ?>
        </div>
      <?php else: ?>
        <div class="page-alert">You have no bookings yet. Explore packages and make your first reservation.</div>
      <?php endif ?>
      <div style="margin-top: 1.5rem;">
          <a class="button" href="/globetrek/pages/packages.php">Browse packages</a>
      </div>
    </div>
    
    <!-- Profile Management -->
    <div class="page-panel" style="margin-bottom:0;">
      <h3>My Profile</h3>
      <form method="post" action="" style="margin-top:1rem;">
        <div class="field">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($customer['full_name']) ?>" required>
        </div>
        <div class="field">
            <label>Phone Number</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
        </div>
        <div class="field">
            <label>Address</label>
            <textarea name="address" rows="3"><?= htmlspecialchars($customer['address'] ?? '') ?></textarea>
        </div>
        <div class="field">
            <button type="submit" name="update_profile" class="button">Update Profile</button>
        </div>
      </form>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>