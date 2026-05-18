<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$package_id = intval($_POST['package_id'] ?? 1);
$user_id = $_SESSION['user']['id'] ?? null;
if(!$name || !$email){
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Missing fields']);
  exit;
}
$sth = $pdo->prepare('INSERT INTO bookings (name,email,package_id,user_id,created_at) VALUES (?,?,?,?,NOW())');
$sth->execute([$name,$email,$package_id,$user_id]);
$id = $pdo->lastInsertId();
header('Content-Type: application/json');
echo json_encode(['success'=>true,'booking_id'=>$id]);
?>