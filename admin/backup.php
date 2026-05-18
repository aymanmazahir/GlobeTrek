<?php
$_title = 'Admin Backup - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
require_role('admin');
require_once __DIR__ . '/../includes/db.php';
include __DIR__ . '/../includes/admin-shell.php';

if(isset($_GET['download'])){
  $files = [
    'users' => $pdo->query('SELECT id,name,email,role,created_at FROM users ORDER BY id')->fetchAll(),
    'packages' => $pdo->query('SELECT id,title,summary,price FROM packages ORDER BY id')->fetchAll(),
    'bookings' => $pdo->query('SELECT id,user_id,name,email,package_id,status,created_at FROM bookings ORDER BY id')->fetchAll(),
    'inquiries' => $pdo->query('SELECT id,name,email,message,created_at FROM inquiries ORDER BY id')->fetchAll(),
  ];

  $archiveName = 'globetrek-backup-' . date('Ymd-His');
  $filesData = [];
  foreach($files as $name => $rows){
    $csv = fopen('php://memory','w');
    if(!empty($rows)){
      fputcsv($csv, array_keys($rows[0]));
      foreach($rows as $row){ fputcsv($csv, $row); }
    }
    rewind($csv);
    $filesData[$name . '.csv'] = stream_get_contents($csv);
    fclose($csv);
  }

  if(class_exists('ZipArchive')){
    $tmpFile = tempnam(sys_get_temp_dir(), 'backup');
    $zip = new ZipArchive();
    if($zip->open($tmpFile, ZipArchive::OVERWRITE) === true){
      foreach($filesData as $name => $content){
        $zip->addFromString($name, $content);
      }
      $zip->close();
      header('Content-Type: application/zip');
      header('Content-Disposition: attachment; filename="' . $archiveName . '.zip"');
      header('Content-Length: ' . filesize($tmpFile));
      readfile($tmpFile);
      unlink($tmpFile);
      exit;
    }
  }

  header('Content-Type: text/plain');
  header('Content-Disposition: attachment; filename="' . $archiveName . '.txt"');
  echo "Backup archive could not be created as a zip file.\n\n";
  foreach($filesData as $name => $content){
    echo "=== $name ===\n";
    echo $content . "\n\n";
  }
  exit;
}
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Backup & exports</span>
    <h2>System backup</h2>
    <p>Download a fresh archive of users, packages, bookings, and inquiries for recovery or reporting.</p>
  </div>
  <div class="page-panel">
    <p>Click the button below to download a complete backup package in ZIP format.</p>
    <a class="button" href="/globetrek/admin/backup.php?download=1">Download backup archive</a>
  </div>
</section>
<?php include __DIR__ . '/../includes/admin-shell-end.php'; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>