<?php
// Set environment runtime variable to force libpq to send TLS SNI headers
putenv("PGSSLMODE=require");
$_ENV['PGSSLMODE'] = 'require';

// Retrieve database credentials
$host     = getenv('POSTGRES_HOST')     ?: getenv('DB_HOST')     ?: 'dpg-dauu9b19fdbs73advpe0-a.virginia-postgres.render.com';
$port     = getenv('POSTGRES_PORT')     ?: getenv('DB_PORT')     ?: '5432';
$dbname   = getenv('POSTGRES_DATABASE') ?: getenv('DB_NAME')     ?: 'coffee_riom';
$user     = getenv('POSTGRES_USER')     ?: getenv('DB_USER')     ?: 'coffee_riom_user';
$password = getenv('POSTGRES_PASSWORD') ?: getenv('DB_PASS')     ?: 'g3Hmf2rt9Y50LopE1BEWB9Yppd5oFO8P';

// Standard DSN with sslmode=require
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5,
        PDO::PGSQL_ATTR_SSL_MODE     => PDO::PGSQL_CONNECTION_REQUIRE,
    ]);
} catch (PDOException $e) {
    // Graceful error capture for admin UI rendering
    $db_connection_error = $e->getMessage();
}
?>
