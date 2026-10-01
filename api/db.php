<?php
// Set environment variable to mandate SSL mode globally
putenv("PGSSLMODE=require");
$_ENV['PGSSLMODE'] = 'require';

// Render external connection string (supports full SNI routing)
$db_url = getenv('DATABASE_URL') 
    ?: getenv('POSTGRES_URL') 
    ?: "postgresql://coffee_riom_user:g3Hmf2rt9Y50LopE1BEWB9Yppd5oFO8P@dpg-dauu9b19fdbs73advpe0-a.virginia-postgres.render.com/coffee_riom?sslmode=require";

// Convert postgresql:// URI format into PDO-compatible libpq DSN format
if (strpos($db_url, 'postgresql://') === 0 || strpos($db_url, 'postgres://') === 0) {
    $parsed = parse_url($db_url);
    $host = $parsed['host'] ?? '';
    $port = $parsed['port'] ?? 5432;
    $dbname = ltrim($parsed['path'] ?? '', '/');
    $user = $parsed['user'] ?? '';
    $password = $parsed['pass'] ?? '';

    // libpq key-value connection string format ensures full SNI pass-through
    $dsn = "pgsql:host={$host} port={$port} dbname={$dbname} sslmode=require";
} else {
    $dsn = $db_url;
}

try {
    $pdo = new PDO($dsn, $user ?? null, $password ?? null, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5,
    ]);
} catch (PDOException $e) {
    // Graceful error capture for admin UI rendering
    $db_connection_error = $e->getMessage();
}
?>
