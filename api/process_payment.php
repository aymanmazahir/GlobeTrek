<?php
require_once __DIR__ . '/../includes/db.php';
header('Content-Type: application/json');
$bookingId = intval($_POST['booking_id'] ?? 0);
if(!$bookingId){
  echo json_encode(['success'=>false,'error'=>'Missing booking ID']);
  exit;
}
$sth = $pdo->prepare('SELECT b.id,b.name,b.email,p.title,p.price FROM bookings b JOIN packages p ON p.id=b.package_id WHERE b.id=? LIMIT 1');
$sth->execute([$bookingId]);
$booking = $sth->fetch();
if(!$booking){
  echo json_encode(['success'=>false,'error'=>'Booking not found']);
  exit;
}
// Simulated payment processing
echo json_encode(['success'=>true,'message'=>'Payment processed for booking #'.$bookingId.'']);
?>