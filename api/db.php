<?php
putenv("PGSSLMODE=require");
$_ENV['PGSSLMODE'] = 'require';

// Retrieve credentials from environment or Neon fallbacks
$host     = getenv('POSTGRES_HOST')     ?: getenv('DB_HOST')     ?: 'YOUR_NEON_POOLER_HOST';
$port     = getenv('POSTGRES_PORT')     ?: getenv('DB_PORT')     ?: '5432';
$dbname   = getenv('POSTGRES_DATABASE') ?: getenv('DB_NAME')     ?: 'neondb';
$user     = getenv('POSTGRES_USER')     ?: getenv('DB_USER')     ?: 'YOUR_NEON_USER';
$password = getenv('POSTGRES_PASSWORD') ?: getenv('DB_PASS')     ?: 'YOUR_NEON_PASSWORD';

$dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5,
    ]);
} catch (PDOException $e) {
    $db_connection_error = $e->getMessage();
}
?>
