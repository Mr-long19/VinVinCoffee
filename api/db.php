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
        PDO::ATTR_TIMEOUT            => 5,
    ]);
} catch (PDOException $e) {
    // DO NOT set http_response_code(500) here, or Vercel will redirect to index.php homepage!
    // Instead, create a dummy $pdo or log error so admin.php can render its UI card safely.
    $db_connection_error = $e->getMessage();
}
?>
