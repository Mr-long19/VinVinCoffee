<?php
$host     = getenv('POSTGRES_HOST')     ?: 'dpg-dauu9b19fdbs73advpe0-a.virginia-postgres.render.com';
$port     = getenv('POSTGRES_PORT')     ?: '5432';
$dbname   = getenv('POSTGRES_DATABASE') ?: 'coffee_riom';
$user     = getenv('POSTGRES_USER')     ?: 'coffee_riom_user';
$password = getenv('POSTGRES_PASSWORD') ?: 'g3Hmf2rt9Y50LopE1BEWB9Yppd5oFO8P';

$dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5,
    ]);
} catch (PDOException $e) {
    $db_connection_error = "Database Connection Failed: " . $e->getMessage();
}
?>
