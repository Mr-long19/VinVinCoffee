<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/db.php';

if (isset($db_connection_error)) {
    echo json_encode([
        'status' => 'error',
        'message' => $db_connection_error
    ]);
    exit;
}

try {
    // Query categories
    $catStmt = $pdo->query("
        SELECT id, 
               COALESCE(name_en, name, 'Category') AS name_en, 
               COALESCE(name_kh, name, 'ប្រភេទ') AS name_kh 
        FROM public.categories 
        ORDER BY id ASC
    ");
    $categories = $catStmt->fetchAll();

    // Query products
    $prodStmt = $pdo->query("
        SELECT id, 
               category_id, 
               COALESCE(name_en, name, 'Item') AS name_en, 
               COALESCE(name_kh, name, 'ទំនិញ') AS name_kh, 
               COALESCE(name_en, name, 'Item') AS name, 
               price, 
               image_url, 
               is_available 
        FROM public.products 
        WHERE is_available = TRUE 
        ORDER BY id ASC
    ");
    $products = $prodStmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'categories' => $categories,
        'products' => $products
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Query Failed: ' . $e->getMessage()
    ]);
}
?>