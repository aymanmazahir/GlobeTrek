<?php
require_once __DIR__ . '/../includes/db.php';
$name = $_POST['name'] ?? null; $email = $_POST['email'] ?? null; $password = $_POST['password'] ?? null;
if(!$name||!$email||!$password){header('Location: /globetrek/pages/register.php?error=1');exit;}
$hash = password_hash($password,PASSWORD_DEFAULT);
$sth = $pdo->prepare('INSERT INTO users (name,email,password_hash,role,created_at) VALUES (?,?,?,?,NOW())');
$sth->execute([$name,$email,$hash,'customer']);
header('Location: /globetrek/pages/login.php?registered=1');
?>