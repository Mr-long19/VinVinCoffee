<?php
// Force SSL mode for libpq execution on Vercel
putenv("PGSSLMODE=require");
$_ENV['PGSSLMODE'] = 'require';

// Render DB Credentials
$host     = getenv('POSTGRES_HOST')     ?: 'dpg-dauu9b19fdbs73advpe0-a.virginia-postgres.render.com';
$port     = getenv('POSTGRES_PORT')     ?: '5432';
$dbname   = getenv('POSTGRES_DATABASE') ?: 'coffee_riom';
$base_user= getenv('POSTGRES_USER')     ?: 'coffee_riom_user';
$password = getenv('POSTGRES_PASSWORD') ?: 'g3Hmf2rt9Y50LopE1BEWB9Yppd5oF08P';

// Extract the Render endpoint ID from host (dpg-dauu9b19fdbs73advpe0)
$endpoint_id = 'dpg-dauu9b19fdbs73advpe0';

// Append $endpoint_id to username to fix missing SNI routing on Vercel PHP
$user = (strpos($base_user, '$') === false) ? $base_user . '$' . $endpoint_id : $base_user;

// DSN string
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
