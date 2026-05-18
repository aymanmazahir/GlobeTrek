<?php
$_title = 'Manage Packages - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('staff');
require_once __DIR__ . '/../includes/db.php';

$message = '';
// Add Package
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add'){
  $title = trim($_POST['title'] ?? '');
  $destination = trim($_POST['destination'] ?? '');
  $summary = trim($_POST['summary'] ?? '');
  $price = floatval($_POST['price'] ?? 0);
  $duration = intval($_POST['duration_days'] ?? 1);
  
  if($title && $destination && $price > 0){
    $sth = $pdo->prepare('INSERT INTO packages (title,destination,summary,price,duration_days) VALUES (?,?,?,?,?)');
    $sth->execute([$title,$destination,$summary,$price,$duration]);
    header('Location: /globetrek/staff/packages.php?added=1');
    exit;
  }
  $message = 'Please provide all required fields correctly.';
}

// Expire Package
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'expire'){
    $package_id = $_POST['package_id'];
    $stmt = $pdo->prepare('UPDATE packages SET status = "expired" WHERE id = ?');
    $stmt->execute([$package_id]);
    header('Location: /globetrek/staff/packages.php?expired=1');
    exit;
}

$added = isset($_GET['added']);
$expired = isset($_GET['expired']);
$packages = $pdo->query('SELECT * FROM packages WHERE status="active" ORDER BY id DESC')->fetchAll();
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Package management</span>
    <h2>Manage travel packages</h2>
    <p>Add new tours, edit details, and remove expired packages from the catalog.</p>
  </div>
  
  <?php if($message): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(window.showToast) window.showToast(<?= json_encode($message) ?>, 'error');
        });
    </script>
  <?php endif ?>
  
  <form method="post" class="page-panel" style="margin-bottom:2rem; background:rgba(0,167,255,0.03); border:1px dashed rgba(0,167,255,0.3);">
    <h3>Add New Package</h3>
    <input type="hidden" name="action" value="add">
    <div class="grid-2" style="display:grid; gap:1rem;">
        <div class="field"><label>Package title</label><input name="title" required></div>
        <div class="field"><label>Destination</label><input name="destination" required></div>
    </div>
    <div class="grid-2" style="display:grid; gap:1rem;">
        <div class="field"><label>Price (USD)</label><input name="price" type="number" step="0.01" min="0" required></div>
        <div class="field"><label>Duration (Days)</label><input name="duration_days" type="number" min="1" required></div>
    </div>
    <div class="field"><label>Summary</label><textarea name="summary"></textarea></div>
    <div class="field"><button type="submit">Add package</button></div>
  </form>
  
  <h3>Active Packages</h3>
  <div class="card-grid grid-2">
    <?php foreach($packages as $package): ?>
      <article class="hero-card" style="border:1px solid rgba(16,34,55,0.1); background:#fff;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <h3 style="color:var(--text); margin-bottom:0.25rem;"><?= htmlspecialchars($package['title']) ?></h3>
            <span class="status-pill status-approved" style="font-size:0.75rem;">$<?= number_format($package['price'],2) ?></span>
        </div>
        <p class="text-muted" style="margin-top:0;"><strong><?= htmlspecialchars($package['destination']) ?></strong> | <?= $package['duration_days'] ?> Days</p>
        <p style="color:var(--text);"><?= htmlspecialchars($package['summary']) ?></p>
        
        <form method="post" style="margin-top:1rem; text-align:right;">
            <input type="hidden" name="action" value="expire">
            <input type="hidden" name="package_id" value="<?= $package['id'] ?>">
            <button type="submit" class="button small" style="background:var(--warning);" onclick="return confirm('Mark this package as expired?');">Delete / Expire</button>
        </form>
      </article>
    <?php endforeach ?>
    
    <?php if(!$packages): ?>
        <p>No active packages found.</p>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>