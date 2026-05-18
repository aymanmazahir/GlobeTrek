<?php
// auth.php - session & role helpers
session_start();

function require_login(){
  if(empty($_SESSION['user'])){
    header('Location: /globetrek/pages/login.php');
    exit;
  }
}

function current_user(){
  return $_SESSION['user'] ?? null;
}

function require_role($role){
  $u = current_user();
  if(!$u || ($u['role'] ?? '') !== $role){
    http_response_code(403); echo 'Forbidden'; exit;
  }
}
?>