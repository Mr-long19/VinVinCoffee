<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database Connection Settings
$host     = '127.0.0.1';
$port     = '5432';
$db       = 'COFFEE';       // Matches your pgAdmin database name
$user     = 'postgres';
$password = 'P@@admin123';  // Matches your PostgreSQL password

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get_menu':
        try {
            $stmt = $pdo->query("SELECT * FROM menu_items ORDER BY id ASC");
            $items = $stmt->fetchAll();
            echo json_encode(['status' => 'success', 'data' => $items]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'get_categories':
        try {
            $stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
            $categories = $stmt->fetchAll();
            echo json_encode(['status' => 'success', 'data' => $categories]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'get_ai_context':
        try {
            $stmt = $pdo->query("SELECT * FROM ai_knowledge_docs");
            $context = $stmt->fetchAll();
            echo json_encode(['status' => 'success', 'context' => $context]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid endpoint action']);
        break;
}