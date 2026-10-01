<?php
$host = getenv('DB_HOST') ?: 'dpg-dauu9bl9fdbs73advpe0-a.virginia-postgres.render.com';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'coffee_riom';
$user = getenv('DB_USER') ?: 'coffee_riom_user';
$pass = getenv('DB_PASS') ?: 'g3Hmf2rt9Y5OLopE1BEWB9Yppd5oFO8P';

$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} 
    // In your db.php:
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database Connection Failed: " . $e->getMessage()]);
    exit;
}
?>
