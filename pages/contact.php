<?php
$_title = 'Contact - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
$sent = isset($_GET['sent']);
$error = isset($_GET['error']);
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Get in touch</span>
    <h2>Contact GlobeTrek Adventures</h2>
    <p>Send your travel inquiry, ask about packages, or request support from our team.</p>
  </div>

  <form action="/globetrek/api/submit_inquiry.php" method="post">
    <div class="field"><label>Name</label><input name="name" required></div>
    <div class="field"><label>Email</label><input name="email" type="email" required></div>
    <div class="field"><label>Message</label><textarea name="message" required></textarea></div>
    <div class="field"><button type="submit">Send inquiry</button></div>
  </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>