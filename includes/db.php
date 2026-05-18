<?php
// db.php - single DB connection (PDO)
$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_NAME = getenv('DB_NAME') ?: 'globetrek';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';

try{
  $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  // Ensure a development admin user exists for dashboard testing
  try {
    $adminEmail = 'admin@globetrek.com';
    $check = $pdo->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
    $check->execute([$adminEmail]);
    if(!$check->fetch()){
      $pdo->prepare('INSERT INTO users (name,email,password_hash,role,created_at) VALUES (?,?,?,?,NOW())')
          ->execute(['GlobeTrek Admin', $adminEmail, password_hash('Admin@123', PASSWORD_BCRYPT), 'admin']);
    }
  } catch(Exception $e) {
    // ignore initialization errors when schema is not ready yet
  }
  try {
    $pdo->exec("ALTER TABLE bookings ADD COLUMN status VARCHAR(32) NOT NULL DEFAULT 'pending'");
  } catch(Exception $e) {
    // ignore if column already exists or table is not present yet
  }
}catch(Exception $e){
  http_response_code(500);
  echo 'Database connection failed: '.htmlspecialchars($e->getMessage());
  exit;
}
?>