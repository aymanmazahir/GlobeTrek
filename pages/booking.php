<?php
$_title = 'Booking - GlobeTrek Adventures';
$_styles = ['/globetrek/assets/css/booking.css'];
$selectedPackage = intval($_GET['package_id'] ?? 0);
include __DIR__ . '/../includes/header.php';
$nameValue = htmlspecialchars($me['name'] ?? '');
$emailValue = htmlspecialchars($me['email'] ?? '');
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Reserve now</span>
    <h2>Book your next tour</h2>
    <p>Complete the form below to reserve your travel package and continue to payment.</p>
  </div>
  <div class="form-card">
    <form id="booking-form" action="/globetrek/api/create_booking.php" method="post">
      <div class="field"><label>Name</label><input name="name" value="<?= $nameValue ?>" required></div>
      <div class="field"><label>Email</label><input name="email" type="email" value="<?= $emailValue ?>" required></div>
      <div class="field"><label>Package</label><select id="package_id" name="package_id"></select></div>
      <div class="field"><button type="submit">Continue to payment</button></div>
    </form>
  </div>
</section>
<script type="module">
import { submitBooking } from '/globetrek/assets/js/booking.js'
import { populatePackageSelect } from '/globetrek/assets/js/site.js'
const form = document.getElementById('booking-form')
populatePackageSelect('package_id', <?= json_encode($selectedPackage) ?>)
form.addEventListener('submit', e=>{e.preventDefault();submitBooking(form)})
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>