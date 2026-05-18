<?php
require_once __DIR__ . '/../includes/db.php';
$name = $_POST['name'] ?? null; 
$email = $_POST['email'] ?? null; 
$password = $_POST['password'] ?? null;

if(!$name || !$email || !$password){
    header('Location: /globetrek/pages/register.php?error=1');
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();
    
    // Insert into users table
    $sth = $pdo->prepare('INSERT INTO users (email, password_hash, role) VALUES (?, ?, ?)');
    $sth->execute([$email, $hash, 'customer']);
    $user_id = $pdo->lastInsertId();
    
    // Insert into customers table
    $sth2 = $pdo->prepare('INSERT INTO customers (user_id, full_name) VALUES (?, ?)');
    $sth2->execute([$user_id, $name]);
    
    $pdo->commit();
    header('Location: /globetrek/pages/login.php?registered=1');
} catch (Exception $e) {
    $pdo->rollBack();
    header('Location: /globetrek/pages/register.php?error=1');
}
?>