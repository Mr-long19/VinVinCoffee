<?php
// Set environment variable to instruct underlying libpq to pass TLS SNI to Render
putenv("PGSSLMODE=require");
$_ENV['PGSSLMODE'] = 'require';

// Retrieve database credentials
$host     = getenv('POSTGRES_HOST')     ?: getenv('DB_HOST')     ?: 'dpg-dauu9b19fdbs73advpe0-a.virginia-postgres.render.com';
$port     = getenv('POSTGRES_PORT')     ?: getenv('DB_PORT')     ?: '5432';
$dbname   = getenv('POSTGRES_DATABASE') ?: getenv('DB_NAME')     ?: 'coffee_riom';
$user     = getenv('POSTGRES_USER')     ?: getenv('DB_USER')     ?: 'coffee_riom_user';
$password = getenv('POSTGRES_PASSWORD') ?: getenv('DB_PASS')     ?: 'g3Hmf2rt9Y50LopE1BEWB9Yppd5oFO8P';

// Include sslmode=require in DSN without referencing undefined PHP constants
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5,
    ]);
} catch (PDOException $e) {
    // Graceful error capture for admin UI rendering
    $db_connection_error = $e->getMessage();
}
?>
