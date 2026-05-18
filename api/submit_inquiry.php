<?php
require_once __DIR__ . '/../includes/db.php';
$name = $_POST['name'] ?? null; $email = $_POST['email'] ?? null; $message = $_POST['message'] ?? null;
if(!$name||!$email||!$message){header('Location: /globetrek/pages/contact.php?error=1');exit;}
$sth = $pdo->prepare('INSERT INTO inquiries (name,email,message,created_at) VALUES (?,?,?,NOW())');
$sth->execute([$name,$email,$message]);
header('Location: /globetrek/pages/contact.php?sent=1');
?>