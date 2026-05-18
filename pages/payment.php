<?php
$_title = 'Payment - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';
$bookingId = intval($_GET['booking_id'] ?? 0);
$booking = null;
if($bookingId){
  $sth = $pdo->prepare('SELECT b.id,b.name,b.email,b.created_at,p.title,p.price FROM bookings b JOIN packages p ON p.id=b.package_id WHERE b.id = ? LIMIT 1');
  $sth->execute([$bookingId]);
  $booking = $sth->fetch();
}
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Secure payment</span>
    <h2>Complete your reservation</h2>
    <p>Review the booking details and confirm payment for your selected tour.</p>
  </div>
  <?php if(!$booking): ?>
    <div class="page-alert">No booking was found. Please make a booking first.</div>
  <?php else: ?>
    <div class="page-panel">
      <p><strong>Package:</strong> <?= htmlspecialchars($booking['title']) ?></p>
      <p><strong>Customer:</strong> <?= htmlspecialchars($booking['name']) ?> (<?= htmlspecialchars($booking['email']) ?>)</p>
      <p><strong>Amount:</strong> $<?= number_format($booking['price'],2) ?></p>
    </div>
    <form id="payment-form">
      <input type="hidden" name="booking_id" value="<?= htmlspecialchars($bookingId) ?>">
      <div class="field"><button type="submit">Complete payment</button></div>
    </form>
    <div id="payment-result" class="page-alert hidden"></div>
    <script type="module">
    import { ajax } from '/globetrek/assets/js/global.js'
    const form = document.getElementById('payment-form')
    const status = document.getElementById('payment-result')
    form.addEventListener('submit', async e => {
      e.preventDefault()
      status.classList.add('hidden')
      const data = new FormData(form)
      const resp = await ajax('/globetrek/api/process_payment.php', {method:'POST',body:data})
      if(resp.success){
        status.textContent = resp.message || 'Payment completed successfully.'
        status.classList.remove('hidden')
      } else {
        status.textContent = resp.error || 'Payment failed. Please try again.'
        status.classList.remove('hidden')
      }
    })
    </script>
  <?php endif ?>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>