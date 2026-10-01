<?php
// Force SSL mode for libpq
putenv("PGSSLMODE=require");
$_ENV['PGSSLMODE'] = 'require';

// Neon Database Credentials
$host     = getenv('POSTGRES_HOST')     ?: getenv('DB_HOST')     ?: 'ep-quiet-night-b5oa8gm9-pooler.c-7.us-east-2.aws.neon.tech';
$port     = getenv('POSTGRES_PORT')     ?: getenv('DB_PORT')     ?: '5432';
$dbname   = getenv('POSTGRES_DATABASE') ?: getenv('DB_NAME')     ?: 'neondb';
$user     = getenv('POSTGRES_USER')     ?: getenv('DB_USER')     ?: 'neondb_owner';

// Replace 'YOUR_ACTUAL_NEON_PASSWORD' with your password from Neon
$password = getenv('POSTGRES_PASSWORD') ?: getenv('DB_PASS')     ?: 'YOUR_ACTUAL_NEON_PASSWORD';

// DSN string configured for Neon Pooler
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
