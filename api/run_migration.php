<?php
require_once __DIR__ . '/../includes/db.php';
$sql = file_get_contents(__DIR__ . '/../database/globetrek.sql');
try {
    $pdo->exec($sql);
    echo "Migration completed successfully!";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>
