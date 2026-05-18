<?php
$_title = 'Admin Reports - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

// Get all packages for the filter drop-down
$packagesList = $pdo->query('SELECT id, title FROM packages ORDER BY title')->fetchAll(PDO::FETCH_ASSOC);

// Dynamic filters configuration
$params = [];
$whereClauses = [];

// Apply status filter
$filterStatus = $_GET['status'] ?? '';
if ($filterStatus !== '') {
  $whereClauses[] = 'b.status = ?';
  $params[] = $filterStatus;
}

// Apply package filter
$filterPackage = intval($_GET['package_id'] ?? 0);
if ($filterPackage > 0) {
  $whereClauses[] = 'b.package_id = ?';
  $params[] = $filterPackage;
}

// Apply date range filter
$filterStart = $_GET['start_date'] ?? '';
if ($filterStart !== '') {
  $whereClauses[] = 'b.created_at >= ?';
  $params[] = $filterStart . ' 00:00:00';
}
$filterEnd = $_GET['end_date'] ?? '';
if ($filterEnd !== '') {
  $whereClauses[] = 'b.created_at <= ?';
  $params[] = $filterEnd . ' 23:59:59';
}

$whereSQL = '';
if (!empty($whereClauses)) {
  $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

// Query filtered report records
$bookingsQuery = "
  SELECT b.id, b.travel_date, b.guests_count, b.status, b.total_price, b.created_at, 
         c.full_name AS customer_name, u.email AS customer_email, p.title AS package_title
  FROM bookings b
  JOIN customers c ON b.customer_id = c.id
  JOIN users u ON c.user_id = u.id
  JOIN packages p ON p.id = b.package_id
  $whereSQL
  ORDER BY b.created_at DESC
";
$bookingsStmt = $pdo->prepare($bookingsQuery);
$bookingsStmt->execute($params);
$reportBookings = $bookingsStmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate metrics based on filtered set
$filteredSales = 0;
$filteredApprovedCount = 0;
$filteredPendingCount = 0;
$totalGuests = 0;

foreach ($reportBookings as $bk) {
  $totalGuests += $bk['guests_count'];
  if ($bk['status'] === 'approved') {
    $filteredSales += $bk['total_price'];
    $filteredApprovedCount++;
  } else if ($bk['status'] === 'pending') {
    $filteredPendingCount++;
  }
}
?>

<style>
  .filter-card {
    background: #fff;
    border: 1px solid rgba(16, 34, 55, 0.08);
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 15px 40px rgba(16, 34, 55, 0.03);
    margin-bottom: 2.5rem;
  }
  .filter-form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    align-items: flex-end;
  }
  @media(min-width: 600px) {
    .filter-form-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media(min-width: 1000px) {
    .filter-form-grid {
      grid-template-columns: repeat(4, 1fr) auto auto;
    }
  }
  .filter-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }
  .filter-item label {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .filter-item select,
  .filter-item input {
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    border-radius: 12px;
    border: 1px solid rgba(16, 34, 55, 0.12);
    background: var(--surface-soft);
    width: 100%;
    transition: all 0.2s ease;
  }
  .filter-item select:focus,
  .filter-item input:focus {
    border-color: var(--accent);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0, 167, 255, 0.08);
  }
  .filter-actions {
    display: flex;
    gap: 0.75rem;
  }
  .metrics-label-row {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--muted);
    margin-bottom: 0.75rem;
  }
  @media print {
    header, .admin-sidebar, .filter-card, .filter-actions, footer {
      display: none !important;
    }
    .admin-content {
      width: 100% !important;
      padding: 0 !important;
      box-shadow: none !important;
    }
  }
</style>

<section class="page-panel fade-up">
  <div class="section-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1.5rem;">
    <div>
      <span class="section-label">Analytics reports</span>
      <h2>Sales & Customer Reports</h2>
      <p>Analyze revenue, customer volumes, and reservation statuses with high-fidelity filtering.</p>
    </div>
    
    <div class="filter-actions">
      <button onclick="window.print()" class="button ghost small" style="display:inline-flex; align-items:center; gap:0.5rem;">
        <span>🖨️</span> Print Report
      </button>
    </div>
  </div>

  <!-- Advanced Report Filters -->
  <div class="filter-card">
    <form method="GET" class="filter-form-grid">
      <div class="filter-item">
        <label>Status</label>
        <select name="status">
          <option value="">All Statuses</option>
          <option value="pending" <?= $filterStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="approved" <?= $filterStatus === 'approved' ? 'selected' : '' ?>>Approved</option>
          <option value="cancelled" <?= $filterStatus === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
      </div>

      <div class="filter-item">
        <label>Travel Package</label>
        <select name="package_id">
          <option value="0">All Packages</option>
          <?php foreach ($packagesList as $pkg): ?>
            <option value="<?= $pkg['id'] ?>" <?= $filterPackage === intval($pkg['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($pkg['title']) ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="filter-item">
        <label>Start Date</label>
        <input type="date" name="start_date" value="<?= htmlspecialchars($filterStart) ?>">
      </div>

      <div class="filter-item">
        <label>End Date</label>
        <input type="date" name="end_date" value="<?= htmlspecialchars($filterEnd) ?>">
      </div>

      <button type="submit" class="button small" style="margin:0; padding:0.85rem 1.4rem;">Filter</button>
      <a href="/globetrek/admin/reports.php" class="button ghost small" style="text-decoration:none; text-align:center; padding:0.85rem 1.4rem;">Reset</a>
    </form>
  </div>

  <!-- Real-time Filtered Metrics -->
  <div class="metrics-label-row">Active Filters Aggregate Statistics</div>
  <div class="card-grid grid-3" style="margin-bottom: 2.5rem;">
    <article class="hero-card" style="background:rgba(33,141,83,0.04); border-color:rgba(33,141,83,0.15);">
      <strong style="color:var(--success); text-transform:uppercase; font-size:0.85rem; letter-spacing:0.05em;">Sales Revenue</strong>
      <p class="text-muted" style="font-size:0.85rem; margin-top:0.15rem;">Approved bookings sum</p>
      <p style="font-size:2rem; font-weight:800; color:var(--text); margin-top:0.5rem;">$<?= number_format($filteredSales, 2) ?></p>
    </article>
    
    <article class="hero-card" style="background:rgba(0,167,255,0.04); border-color:rgba(0,167,255,0.15);">
      <strong style="color:var(--accent-dark); text-transform:uppercase; font-size:0.85rem; letter-spacing:0.05em;">Approved Bookings</strong>
      <p class="text-muted" style="font-size:0.85rem; margin-top:0.15rem;">Confirmed travel tickets</p>
      <p style="font-size:2rem; font-weight:800; color:var(--text); margin-top:0.5rem;"><?= htmlspecialchars($filteredApprovedCount) ?></p>
    </article>

    <article class="hero-card" style="background:rgba(255,138,43,0.04); border-color:rgba(255,138,43,0.15);">
      <strong style="color:var(--warning); text-transform:uppercase; font-size:0.85rem; letter-spacing:0.05em;">Pending Bookings</strong>
      <p class="text-muted" style="font-size:0.85rem; margin-top:0.15rem;">Awaiting administrative sign-off</p>
      <p style="font-size:2rem; font-weight:800; color:var(--text); margin-top:0.5rem;"><?= htmlspecialchars($filteredPendingCount) ?></p>
    </article>
  </div>

  <!-- Detailed Report Table -->
  <div class="page-panel" style="margin: 0; padding: 2rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
      <h3 style="margin:0; font-size:1.25rem; font-weight:800;">Detailed Booking Registry</h3>
      <span class="status-pill status-approved" style="background:rgba(0,167,255,0.08); color:var(--accent-dark); font-weight:700;">
        <?= count($reportBookings) ?> Record(s) Found
      </span>
    </div>

    <?php if (empty($reportBookings)): ?>
      <div class="page-alert" style="background:var(--surface-soft); border-color:rgba(0,0,0,0.05); color:var(--muted); margin:0;">
        No bookings match your current filter parameters.
      </div>
    <?php else: ?>
      <div style="overflow-x:auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Package</th>
              <th>Travel Date</th>
              <th>Guests</th>
              <th>Status</th>
              <th>Total Price</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reportBookings as $bk): ?>
              <tr>
                <td style="font-weight:700;">#<?= htmlspecialchars($bk['id']) ?></td>
                <td>
                  <strong><?= htmlspecialchars($bk['customer_name']) ?></strong><br>
                  <span style="font-size:0.82rem; color:var(--muted);"><?= htmlspecialchars($bk['customer_email']) ?></span>
                </td>
                <td><?= htmlspecialchars($bk['package_title']) ?></td>
                <td><?= htmlspecialchars($bk['travel_date']) ?></td>
                <td style="font-weight:600;"><?= htmlspecialchars($bk['guests_count']) ?></td>
                <td>
                  <span class="status-pill status-<?= htmlspecialchars($bk['status']) ?>">
                    <?= ucfirst(htmlspecialchars($bk['status'])) ?>
                  </span>
                </td>
                <td style="font-weight:700; color:var(--accent-dark);">$<?= number_format($bk['total_price'], 2) ?></td>
                <td style="font-size:0.85rem; color:var(--muted);"><?= date('Y-m-d H:i', strtotime($bk['created_at'])) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    <?php endif ?>
  </div>
</section>

<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>