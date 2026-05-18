<?php
require_once __DIR__ . '/../includes/db.php';
$q = trim($_GET['q'] ?? '');
if($q !== ''){
  $sth = $pdo->prepare('SELECT id,title,price,summary FROM packages WHERE title LIKE ? OR summary LIKE ? LIMIT 50');
  $like = "%$q%";
  $sth->execute([$like,$like]);
}else{
  $sth = $pdo->query('SELECT id,title,price,summary FROM packages LIMIT 50');
}
$rows = $sth->fetchAll();
header('Content-Type: application/json');
echo json_encode(['success'=>true,'data'=>$rows]);
?>