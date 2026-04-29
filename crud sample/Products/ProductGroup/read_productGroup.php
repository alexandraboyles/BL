<?php
declare(strict_types=1);

// ------------------------------------------------------------
// Allow CLI arpguments like key=value&key2=value2
// ------------------------------------------------------------
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
}

require __DIR__ . '/../../../db_connect.php';

try {
    // --------------------------------------------------------
    // Collect input (at least ONE filter is required)
    // --------------------------------------------------------
    $customer_id               = $_POST['customer_id'] ?? null;    // UUID → Customer.id
    $productType_id            = $_POST['productType_id'] ?? null;    
    $productGroup_name         = $_POST['productGroup_name'] ?? null;     
    $productGroup_description  = $_POST['productGroup_description'] ?? null; 

    if (
        $customer_id === null &&
        $productType_id === null &&
        $productGroup_name === null &&
        $productGroup_description === null
    ) {
        throw new InvalidArgumentException(
            'At least one filter is required'
        );
    }

    // --------------------------------------------------------
    // Build dynamic WHERE clause
    // --------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($customer_id !== null) {
        $conditions[] = 'pg.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    if ($productType_id !== null) {
        $conditions[] = 'pg.productType_id = :productType_id';
        $params[':productType_id'] = $productType_id;
    }

    if ($productGroup_name !== null) {
        $conditions[] = 'pg.productGroup_name = :productGroup_name';
        $params[':productGroup_name'] = $productGroup_name;
    }

    if ($productGroup_description !== null) {
        $conditions[] = 'pg.$productGroup_description = :$productGroup_description';
        $params[':$productGroup_description'] = $productGroup_description;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Product Group
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            pg.id,
            pg.customer_id,
            pg.productType_id,
            pg.productGroup_name,
            pg.productGroup_description
         FROM productGroup pg
         WHERE $whereSql"
    );

    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --------------------------------------------------------
    // Output JSON
    // --------------------------------------------------------
    echo json_encode([
        'status' => 'success',
        'count'  => count($rows),
        'data'   => $rows
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    http_response_code(400);

    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
}

//Run:
//List all product groups for a customer
    //php read_productGroup.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187
//Read product group by product type
    //php read_productGroup.php productType_id=1
