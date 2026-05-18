<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
$email = $_POST['email'] ?? null; $password = $_POST['password'] ?? null;
if(!$email||!$password){header('Location: /globetrek/pages/login.php?error=1');exit;}
$sth = $pdo->prepare('SELECT id,name,email,role,password_hash FROM users WHERE email=? LIMIT 1');
$sth->execute([$email]); $u = $sth->fetch();
if($u && password_verify($password,$u['password_hash'])){
  $_SESSION['user'] = ['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
  if(($u['role'] ?? '') === 'admin'){
    header('Location: /globetrek/admin/dashboard.php');
  } elseif(($u['role'] ?? '') === 'staff'){
    header('Location: /globetrek/staff/dashboard.php');
  } else {
    header('Location: /globetrek/customer/dashboard.php');
  }
  exit;
}
header('Location: /globetrek/pages/login.php?error=1');
?>