<?php
$_title = 'Manage Packages - Admin - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

$message = '';
$uploadDir = __DIR__ . '/../assets/images/packages/';

// Handle Add Package
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = trim($_POST['title'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $duration = intval($_POST['duration_days'] ?? 1);
    $image_url = 'default_package.jpg'; // default

    // Handle File Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($fileExt, $allowed)) {
            $newFileName = uniqid('pkg_') . '.' . $fileExt;
            $destPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($tmpName, $destPath)) {
                $image_url = $newFileName;
            } else {
                $message = "File upload failed.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
        }
    }

    if ($title && $destination && $price > 0 && !$message) {
        $sth = $pdo->prepare('INSERT INTO packages (title, destination, summary, price, duration_days, image_url) VALUES (?, ?, ?, ?, ?, ?)');
        $sth->execute([$title, $destination, $summary, $price, $duration, $image_url]);
        header('Location: /globetrek/admin/packages.php?added=1');
        exit;
    } elseif (!$message) {
        $message = 'Please provide all required fields correctly.';
    }
}

// Handle Edit Package
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $package_id = intval($_POST['package_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $duration = intval($_POST['duration_days'] ?? 1);

    // Fetch existing image url in case we don't upload a new one
    $existingStmt = $pdo->prepare('SELECT image_url FROM packages WHERE id = ?');
    $existingStmt->execute([$package_id]);
    $image_url = $existingStmt->fetchColumn() ?: 'default_package.jpg';

    // Handle File Upload if provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($fileExt, $allowed)) {
            $newFileName = uniqid('pkg_') . '.' . $fileExt;
            $destPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($tmpName, $destPath)) {
                $image_url = $newFileName;
            } else {
                $message = "File upload failed.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
        }
    }

    if ($package_id && $title && $destination && $price > 0 && !$message) {
        $sth = $pdo->prepare('UPDATE packages SET title = ?, destination = ?, summary = ?, price = ?, duration_days = ?, image_url = ? WHERE id = ?');
        $sth->execute([$title, $destination, $summary, $price, $duration, $image_url, $package_id]);
        header('Location: /globetrek/admin/packages.php?updated=1');
        exit;
    } elseif (!$message) {
        $message = 'Please provide all required fields correctly.';
    }
}

// Handle Expire Package
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'expire') {
    $package_id = $_POST['package_id'];
    $stmt = $pdo->prepare('UPDATE packages SET status = "expired" WHERE id = ?');
    $stmt->execute([$package_id]);
    header('Location: /globetrek/admin/packages.php?expired=1');
    exit;
}

$packages = $pdo->query('SELECT * FROM packages WHERE status="active" ORDER BY id DESC')->fetchAll();
?>

<section class="page-panel fade-up">
  <div class="admin-action-row" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <span class="section-label">Package management</span>
      <h2>Manage travel packages</h2>
      <p>Add new tours, edit details in real-time, and control package visibility in the catalog.</p>
    </div>
    <button class="button" data-modal-open="#modalAddPackage" data-modal-title="Add New Package">Add Package</button>
  </div>
  
  <?php if($message): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(window.showToast) window.showToast(<?= json_encode($message) ?>, 'error');
        });
    </script>
  <?php endif ?>
  
  <h3>Active Packages</h3>
  <div class="card-grid grid-2">
    <?php foreach($packages as $package): ?>
      <article class="hero-card" style="border:1px solid rgba(16,34,55,0.1); background:#fff; overflow:hidden; padding:0; border-radius: 20px;">
        <?php if($package['image_url'] !== 'default_package.jpg'): ?>
            <img src="/globetrek/assets/images/packages/<?= htmlspecialchars($package['image_url']) ?>" alt="Package Image" style="width:100%; height:200px; object-fit:cover;">
        <?php else: ?>
            <div style="width:100%; height:200px; background:var(--accent-soft); display:flex; align-items:center; justify-content:center; color:var(--accent-dark);">No Image Provided</div>
        <?php endif; ?>
        
        <div style="padding:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <h3 style="color:var(--text); margin-bottom:0.25rem; font-size:1.2rem;"><?= htmlspecialchars($package['title']) ?></h3>
                <span class="status-pill status-approved" style="font-size:0.75rem;">$<?= number_format($package['price'],2) ?></span>
            </div>
            <p class="text-muted" style="margin-top:0.25rem; font-size:0.9rem;"><strong><?= htmlspecialchars($package['destination']) ?></strong> | <?= $package['duration_days'] ?> Days</p>
            <p style="color:var(--text); font-size:0.95rem; margin-bottom:1rem;"><?= htmlspecialchars($package['summary']) ?></p>
            
            <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid rgba(0,0,0,0.05); padding-top:1rem; margin-top:1rem;">
                <button class="button small ghost" data-modal-open="#modalEditPackage-<?= $package['id'] ?>" data-modal-title="Edit Package Details">Edit Details</button>
                <form method="post" style="margin:0;">
                    <input type="hidden" name="action" value="expire">
                    <input type="hidden" name="package_id" value="<?= $package['id'] ?>">
                    <button type="submit" class="button small" style="background:var(--warning);" onclick="return confirm('Mark this package as expired?');">Delete / Expire</button>
                </form>
            </div>
        </div>
      </article>
    <?php endforeach ?>
    
    <?php if(!$packages): ?>
        <p>No active packages found.</p>
    <?php endif; ?>
  </div>
</section>

<!-- Add Package Modal Template -->
<template id="modalAddPackage">
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
    
    <div class="field"><label>Package Title</label><input name="title" required></div>
    <div class="field"><label>Destination</label><input name="destination" required></div>
    
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
        <div class="field"><label>Price (USD)</label><input name="price" type="number" step="0.01" min="0" required></div>
        <div class="field"><label>Duration (Days)</label><input name="duration_days" type="number" min="1" required></div>
    </div>
    
    <div class="field">
        <label>Cover Image</label>
        <input type="file" name="image" accept="image/jpeg, image/png, image/webp" style="background:#fff; padding:0.5rem;" required>
        <small class="text-muted">Formats: JPG, PNG, WEBP</small>
    </div>
    
    <div class="field"><label>Summary</label><textarea name="summary" required></textarea></div>
    
    <div class="field" style="margin-top:1.5rem;"><button type="submit" class="button">Upload & Create Package</button></div>
  </form>
</template>

<!-- Edit Package Modal Templates -->
<?php foreach($packages as $package): ?>
<template id="modalEditPackage-<?= $package['id'] ?>">
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="package_id" value="<?= $package['id'] ?>">
    
    <div class="field"><label>Package Title</label><input name="title" value="<?= htmlspecialchars($package['title']) ?>" required></div>
    <div class="field"><label>Destination</label><input name="destination" value="<?= htmlspecialchars($package['destination']) ?>" required></div>
    
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
        <div class="field"><label>Price (USD)</label><input name="price" type="number" step="0.01" min="0" value="<?= htmlspecialchars($package['price']) ?>" required></div>
        <div class="field"><label>Duration (Days)</label><input name="duration_days" type="number" min="1" value="<?= htmlspecialchars($package['duration_days']) ?>" required></div>
    </div>
    
    <div class="field">
        <label>Change Cover Image <small class="text-muted">(optional)</small></label>
        <input type="file" name="image" accept="image/jpeg, image/png, image/webp" style="background:#fff; padding:0.5rem;">
        <small class="text-muted">Leave blank to keep current cover image</small>
    </div>
    
    <div class="field"><label>Summary</label><textarea name="summary" required><?= htmlspecialchars($package['summary']) ?></textarea></div>
    
    <div class="field" style="margin-top:1.5rem;"><button type="submit" class="button">Save Changes</button></div>
  </form>
</template>
<?php endforeach ?>

<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>
