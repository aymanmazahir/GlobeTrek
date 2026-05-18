<?php
$_title = 'Manage Packages - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('staff');
require_once __DIR__ . '/../includes/db.php';
$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $title = trim($_POST['title'] ?? '');
  $summary = trim($_POST['summary'] ?? '');
  $price = floatval($_POST['price'] ?? 0);
  if($title && $price > 0){
    $sth = $pdo->prepare('INSERT INTO packages (title,summary,price) VALUES (?,?,?)');
    $sth->execute([$title,$summary,$price]);
    header('Location: /globetrek/staff/packages.php?added=1');
    exit;
  }
  $message = 'Please provide a title and valid price.';
}
$added = isset($_GET['added']);
$packages = $pdo->query('SELECT id,title,summary,price FROM packages ORDER BY id DESC')->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Package management</span>
    <h2>Manage travel packages</h2>
    <p>Add new tours and keep your package catalog updated for customers.</p>
  </div>
  <?php if($added): ?>
    <div class="page-alert">Package added successfully.</div>
  <?php elseif($message): ?>
    <div class="page-alert"><?= htmlspecialchars($message) ?></div>
  <?php endif ?>
  <form method="post" class="page-panel" style="margin-bottom:2rem;">
    <div class="field"><label>Package title</label><input name="title" required></div>
    <div class="field"><label>Summary</label><textarea name="summary"></textarea></div>
    <div class="field"><label>Price (USD)</label><input name="price" type="number" step="0.01" min="0" required></div>
    <div class="field"><button type="submit">Add package</button></div>
  </form>
  <div class="card-grid grid-2">
    <?php foreach($packages as $package): ?>
      <article class="testimonial-card">
        <h3><?= htmlspecialchars($package['title']) ?></h3>
        <p class="text-muted">$<?= number_format($package['price'],2) ?></p>
        <p><?= htmlspecialchars($package['summary']) ?></p>
      </article>
    <?php endforeach ?>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>