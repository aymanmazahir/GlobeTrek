<?php
require_once __DIR__ . '/../includes/db.php';
session_start();

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$package_id = intval($_POST['package_id'] ?? 0);
$travel_date = $_POST['travel_date'] ?? date('Y-m-d', strtotime('+1 day'));
$guests_count = intval($_POST['guests_count'] ?? 1);

if(!$name || !$email || !$package_id){
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Name, email, and package are required fields.']);
  exit;
}

try {
  $pdo->beginTransaction();
  
  // Find or create customer
  $stmt = $pdo->prepare('SELECT c.id FROM customers c JOIN users u ON c.user_id = u.id WHERE u.email = ?');
  $stmt->execute([$email]);
  $customerId = $stmt->fetchColumn();
  
  if(!$customerId){
    // Create new user
    $hash = password_hash('Customer123', PASSWORD_BCRYPT);
    $stmtUser = $pdo->prepare('INSERT INTO users (email, password_hash, role) VALUES (?, ?, "customer")');
    $stmtUser->execute([$email, $hash]);
    $newUserId = $pdo->lastInsertId();
    
    // Create customer profile
    $stmtCust = $pdo->prepare('INSERT INTO customers (user_id, full_name) VALUES (?, ?)');
    $stmtCust->execute([$newUserId, $name]);
    $customerId = $pdo->lastInsertId();
  }
  
  // Get package price
  $pkgStmt = $pdo->prepare('SELECT price FROM packages WHERE id = ?');
  $pkgStmt->execute([$package_id]);
  $price = $pkgStmt->fetchColumn() ?: 0.00;
  $totalPrice = $price * $guests_count;
  
  // Insert booking
  $stmtBk = $pdo->prepare('INSERT INTO bookings (customer_id, package_id, travel_date, guests_count, status, total_price) VALUES (?, ?, ?, ?, "pending", ?)');
  $stmtBk->execute([$customerId, $package_id, $travel_date, $guests_count, $totalPrice]);
  $bookingId = $pdo->lastInsertId();
  
  $pdo->commit();
  header('Content-Type: application/json');
  echo json_encode(['success'=>true, 'booking_id'=>$bookingId]);
} catch (Exception $e) {
  $pdo->rollBack();
  header('Content-Type: application/json');
  echo json_encode(['success'=>false, 'error'=>'Error creating booking: ' . $e->getMessage()]);
}
?>