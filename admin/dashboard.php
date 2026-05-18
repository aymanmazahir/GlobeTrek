<?php
$_title = 'Admin Dashboard - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

// Fetch standard summary counts
$userCount = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$packageCount = $pdo->query('SELECT COUNT(*) FROM packages')->fetchColumn();
$bookingCount = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$inquiryCount = $pdo->query('SELECT COUNT(*) FROM inquiries')->fetchColumn();

$approvedCountStmt = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE status = ?');
$approvedCountStmt->execute(['approved']);
$approvedCount = $approvedCountStmt->fetchColumn();

$pendingCountStmt = $pdo->prepare('SELECT COUNT(*) FROM bookings WHERE status = ?');
$pendingCountStmt->execute(['pending']);
$pendingCount = $pendingCountStmt->fetchColumn();

// --- CHART DATA LOADERS (REAL DATA WITH FALLBACKS) ---

// 1. Status Distribution
$statusStmt = $pdo->query('SELECT status, COUNT(*) AS count FROM bookings GROUP BY status');
$statusData = $statusStmt->fetchAll(PDO::FETCH_ASSOC);
$statusLabels = [];
$statusCounts = [];
foreach($statusData as $row) {
  $statusLabels[] = ucfirst($row['status']);
  $statusCounts[] = intval($row['count']);
}
if(empty($statusLabels)) {
  $statusLabels = ['No Bookings Yet'];
  $statusCounts = [1];
}

// 2. Monthly Revenue
$revStmt = $pdo->query('
  SELECT DATE_FORMAT(created_at, "%Y-%m") AS raw_month, DATE_FORMAT(created_at, "%b %Y") AS month, SUM(total_price) AS revenue 
  FROM bookings 
  WHERE status = "approved" 
  GROUP BY raw_month, month 
  ORDER BY raw_month ASC 
  LIMIT 6
');
$revData = $revStmt->fetchAll(PDO::FETCH_ASSOC);
$revLabels = [];
$revValues = [];
foreach($revData as $row) {
  $revLabels[] = $row['month'];
  $revValues[] = floatval($row['revenue']);
}
if(empty($revLabels)) {
  $revLabels = [date('b Y')];
  $revValues = [0];
}

// 3. Package Popularity
$popStmt = $pdo->query('
  SELECT p.title, COUNT(b.id) AS booking_count 
  FROM bookings b 
  JOIN packages p ON p.id = b.package_id 
  GROUP BY p.title 
  ORDER BY booking_count DESC 
  LIMIT 5
');
$popData = $popStmt->fetchAll(PDO::FETCH_ASSOC);
$popLabels = [];
$popCounts = [];
foreach($popData as $row) {
  $popLabels[] = strlen($row['title']) > 20 ? substr($row['title'], 0, 18) . '..' : $row['title'];
  $popCounts[] = intval($row['booking_count']);
}
if(empty($popLabels)) {
  $popLabels = ['No Data Available'];
  $popCounts = [0];
}
?>

<style>
  .dashboard-grid-modern {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-top: 3rem;
  }
  @media(min-width: 990px) {
    .dashboard-grid-modern {
      grid-template-columns: 2fr 1fr;
    }
  }
  .chart-card {
    background: #fff;
    border: 1px solid rgba(16, 34, 55, 0.08);
    border-radius: 24px;
    padding: 2.2rem;
    box-shadow: 0 15px 40px rgba(16, 34, 55, 0.03);
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    min-height: 380px;
  }
  .chart-card h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text);
    margin: 0;
  }
  .chart-container-box {
    position: relative;
    flex: 1;
    width: 100%;
    height: 100%;
    min-height: 280px;
  }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Admin dashboard</span>
    <h2>Administrator Overview</h2>
    <p>Monitor system activity, track bookings, and manage users from one central control panel.</p>
  </div>
  
  <!-- Stats row -->
  <div class="card-grid grid-3">
    <article class="hero-card" style="background:rgba(0,167,255,0.04); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark); font-weight:800;">Users</h3>
      <p class="text-muted" style="font-size:0.9rem;">Registered accounts</p>
      <p style="font-size:2.2rem; font-weight:800; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($userCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(0,167,255,0.04); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark); font-weight:800;">Packages</h3>
      <p class="text-muted" style="font-size:0.9rem;">Active tour packages</p>
      <p style="font-size:2.2rem; font-weight:800; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($packageCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(0,167,255,0.04); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark); font-weight:800;">Total Bookings</h3>
      <p class="text-muted" style="font-size:0.9rem;">All reservations</p>
      <p style="font-size:2.2rem; font-weight:800; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($bookingCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(33,141,83,0.04); border:1px solid rgba(33,141,83,0.15);">
      <h3 style="color:var(--success); font-weight:800;">Approved</h3>
      <p class="text-muted" style="font-size:0.9rem;">Confirmed bookings</p>
      <p style="font-size:2.2rem; font-weight:800; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($approvedCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(255,138,43,0.04); border:1px solid rgba(255,138,43,0.15);">
      <h3 style="color:var(--warning); font-weight:800;">Pending</h3>
      <p class="text-muted" style="font-size:0.9rem;">Awaiting approval</p>
      <p style="font-size:2.2rem; font-weight:800; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($pendingCount) ?></p>
    </article>
    <article class="hero-card" style="background:rgba(0,167,255,0.04); border:1px solid rgba(0,167,255,0.15);">
      <h3 style="color:var(--accent-dark); font-weight:800;">Inquiries</h3>
      <p class="text-muted" style="font-size:0.9rem;">Support requests</p>
      <p style="font-size:2.2rem; font-weight:800; color:var(--text); margin:0.5rem 0 0;"><?= htmlspecialchars($inquiryCount) ?></p>
    </article>
  </div>

  <!-- Real Data Charts -->
  <div class="dashboard-grid-modern">
    <!-- 1. Line Chart: Sales Revenue -->
    <div class="chart-card">
      <h3>Monthly Approved Bookings Revenue</h3>
      <div class="chart-container-box">
        <canvas id="salesChart"></canvas>
      </div>
    </div>

    <!-- 2. Donut Chart: Status Distribution -->
    <div class="chart-card">
      <h3>Booking Statuses</h3>
      <div class="chart-container-box">
        <canvas id="statusChart"></canvas>
      </div>
    </div>

    <!-- 3. Horizontal Bar Chart: Popular Packages -->
    <div class="chart-card" style="grid-column: span 1;">
      <h3>Top Trending Travel Packages</h3>
      <div class="chart-container-box">
        <canvas id="popularityChart"></canvas>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    // 1. Sales Line Chart
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
      type: 'line',
      data: {
        labels: <?= json_encode($revLabels) ?>,
        datasets: [{
          label: 'Total Revenue ($)',
          data: <?= json_encode($revValues) ?>,
          borderColor: '#00a7ff',
          backgroundColor: 'rgba(0, 167, 255, 0.08)',
          fill: true,
          tension: 0.35,
          borderWidth: 3,
          pointBackgroundColor: '#006eb1',
          pointRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: value => '$' + value
            }
          }
        }
      }
    });

    // 2. Status Donut Chart
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
      type: 'doughnut',
      data: {
        labels: <?= json_encode($statusLabels) ?>,
        datasets: [{
          data: <?= json_encode($statusCounts) ?>,
          backgroundColor: ['#b37800', '#117a37', '#b03d21', '#006eb1'],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 15
            }
          }
        }
      }
    });

    // 3. Popularity Bar Chart
    const ctxPop = document.getElementById('popularityChart').getContext('2d');
    new Chart(ctxPop, {
      type: 'bar',
      data: {
        labels: <?= json_encode($popLabels) ?>,
        datasets: [{
          label: 'Bookings Count',
          data: <?= json_encode($popCounts) ?>,
          backgroundColor: 'rgba(255, 139, 43, 0.85)',
          borderColor: '#ff8b2b',
          borderWidth: 1.5,
          borderRadius: 8
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        }
      }
    });
  });
</script>

<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>