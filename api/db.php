<?php
// Retrieve database connection credentials supporting both naming conventions
$host = getenv('POSTGRES_HOST')     ?: getenv('DB_HOST')     ?: 'dpg-dauu9b19fdbs73advpe0-a.virginia-postgres.render.com';
$port = getenv('POSTGRES_PORT')     ?: getenv('DB_PORT')     ?: '5432';
$dbname = getenv('POSTGRES_DATABASE') ?: getenv('DB_NAME')     ?: 'coffee_riom';
$user = getenv('POSTGRES_USER')     ?: getenv('DB_USER')     ?: 'coffee_riom_user';
$password = getenv('POSTGRES_PASSWORD') ?: getenv('DB_PASS')     ?: 'g3Hmf2rt9Y50LopE1BEWB9Yppd5oFO8P';

// Simple DSN without sslmode query params
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5,
        PDO::PGSQL_ATTR_SSL_MODE     => PDO::PGSQL_CONNECTION_REQUIRE,
    ]);
} catch (PDOException $e) {
    // Save error message to be displayed cleanly in admin UI without throwing HTTP 500
    $db_connection_error = $e->getMessage();
}
?>
