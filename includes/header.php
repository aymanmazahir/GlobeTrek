<?php
// header.php
require_once __DIR__.'/auth.php';
$me = current_user();
$isAdminPage = str_contains($_SERVER['REQUEST_URI'] ?? '', '/admin/');
$pageTitle = $_title ?? 'GlobeTrek';
$pageStyles = $_styles ?? [];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="/globetrek/assets/css/global.css">
<?php foreach($pageStyles as $style): ?>
  <link rel="stylesheet" href="<?= htmlspecialchars($style) ?>">
<?php endforeach ?>
</head>
<body class="<?= $isAdminPage ? 'admin-page' : '' ?>">
<header>
  <div class="container">
    <div class="brand">
      <img src="/globetrek/assets/images/logo.svg" alt="GlobeTrek logo">
      <span>GlobeTrek Adventures</span>
    </div>
    <?php if(!$isAdminPage): ?>
    <nav>
      <a class="nav-link" href="/globetrek/pages/index.php">Home</a>
      <a class="nav-link" href="/globetrek/pages/about.php">About</a>
      <a class="nav-link" href="/globetrek/pages/packages.php">Packages</a>
      <a class="nav-link" href="/globetrek/pages/contact.php">Contact</a>
      <?php if($me): ?>
        <?php if(($me['role'] ?? '') === 'admin'): ?>
          <a class="nav-link" href="/globetrek/admin/dashboard.php">Dashboard</a>
        <?php elseif(($me['role'] ?? '') === 'staff'): ?>
          <a class="nav-link" href="/globetrek/staff/dashboard.php">Dashboard</a>
        <?php else: ?>
          <a class="nav-link" href="/globetrek/customer/dashboard.php">Dashboard</a>
        <?php endif ?>
        <a class="nav-button" href="/globetrek/pages/logout.php">Logout</a>
      <?php else: ?>
        <a class="nav-link" href="/globetrek/pages/login.php">Login</a>
        <a class="nav-button" href="/globetrek/pages/register.php">Register</a>
      <?php endif ?>
    </nav>
    <?php endif ?>
  </div>
</header>
<main class="container">