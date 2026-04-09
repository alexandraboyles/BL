<?php
declare(strict_types=1);

// ------------------------------------------------------------
// Allow CLI arguments like key=value&key2=value2
// ------------------------------------------------------------
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
}

require __DIR__ . '/../../db_connect.php';

try {
    // --------------------------------------------------------
    // Collect input (at least ONE filter is required)
    // --------------------------------------------------------
    $id          = $_POST['id'] ?? null;          // Product UUID
    $product_id  = $_POST['product_id'] ?? null;  // Business product ID
    $customer_id = $_POST['customer_id'] ?? null; // Customer UUID

    if ($id === null && $product_id === null && $customer_id === null) {
        throw new InvalidArgumentException(
            'At least one filter is required: id, product_id, or customer_id'
        );
    }

    // --------------------------------------------------------
    // Build WHERE clause dynamically
    // --------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($id !== null) {
        $conditions[] = 'id = :id';
        $params[':id'] = $id;
    }

    if ($product_id !== null) {
        $conditions[] = 'product_id = :product_id';
        $params[':product_id'] = $product_id;
    }

    if ($customer_id !== null) {
        $conditions[] = 'customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch products
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            id,
            product_id,
            customer_id,
            title,
            description,
            sku,
            unitOfMeasure,
            width,
            length,
            height,
            weight
         FROM Product
         WHERE $whereSql
         ORDER BY title"
    );

    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$products) {
        echo json_encode([
            'status' => 'success',
            'count'  => 0,
            'data'   => []
        ]);
        exit;
    }

    // --------------------------------------------------------
    // Output JSON
    // --------------------------------------------------------
    echo json_encode([
        'status' => 'success',
        'count'  => count($products),
        'data'   => $products
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    http_response_code(400);

    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
}

//Run:
//Read single product by id
//php read_product.php product_id=1002
//List all products for a customer
//php read_product.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187
//Read single product by UUID
//php read_product.php id=48bd8480-e896-41a1-9343-bc48f585bbf8