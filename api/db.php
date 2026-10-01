<?php
// Set libpq environment runtime variables to force SSL mode
putenv("PGSSLMODE=require");
$_ENV['PGSSLMODE'] = 'require';

// Retrieve database credentials
$host     = getenv('POSTGRES_HOST')     ?: getenv('DB_HOST')     ?: 'dpg-dauu9b19fdbs73advpe0-a.virginia-postgres.render.com';
$port     = getenv('POSTGRES_PORT')     ?: getenv('DB_PORT')     ?: '5432';
$dbname   = getenv('POSTGRES_DATABASE') ?: getenv('DB_NAME')     ?: 'coffee_riom';
$user     = getenv('POSTGRES_USER')     ?: getenv('DB_USER')     ?: 'coffee_riom_user';
$password = getenv('POSTGRES_PASSWORD') ?: getenv('DB_PASS')     ?: 'g3Hmf2rt9Y50LopE1BEWB9Yppd5oFO8P';

// Full libpq PostgreSQL URI string (Forces SNI header preservation on Vercel)
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require;sslrootcert=";

// Alternative URI format if PDO driver fails standard DSN parsing:
$connectionUri = "pgsql:uri=postgresql://{$user}:" . rawurlencode($password) . "@{$host}:{$port}/{$dbname}?sslmode=require";

try {
    // Attempt standard DSN with sslmode parameter
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT            => 5,
    ]);
} catch (PDOException $e) {
    try {
        // Fallback to URI format for older pdo_pgsql drivers
        $pdo = new PDO($connectionUri, null, null, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT            => 5,
        ]);
    } catch (PDOException $ex) {
        $db_connection_error = $ex->getMessage();
    }
}
?>
