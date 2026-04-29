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

require __DIR__ . '/../../../db_connect.php';

try {
    // --------------------------------------------------------
    // Collect input (at least ONE filter is required)
    // --------------------------------------------------------
    $saleOrder_id   = $_POST['saleOrder_id'] ?? null; // SaleOrder.id
    $customer_id    = $_POST['customer_id'] ?? null; // Customer.id
    $consignment_id = $_POST['consignment_id'] ?? null; // Consignment.id

    if ($saleOrder_id === null && $customer_id === null && $consignment_id === null) {
        throw new InvalidArgumentException(
            'At least one filter is required: saleOrder_id or customer_id or consignment_id'
        );
    }

    // --------------------------------------------------------
    // Build dynamic WHERE clause
    // --------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($saleOrder_id !== null) {
        $conditions[] = 'astring.saleOrder_id = :saleOrder_id';
        $params[':saleOrder_id'] = $saleOrder_id;
    }

    if ($customer_id !== null) {
        $conditions[] = 'astring.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }
    
    if ($consignment_id !== null) {
        $conditions[] = 'astring.consignment_id = :consignment_id';
        $params[':consignment_id'] = $consignment_id;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Document
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            astring.id,
            astring.saleOrder_id,
            astring.customer_id,
            astring.consignment_id,
            astring.fileType
         FROM document astring
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
//Read documents by saleOrder_id
    //php read_document.php saleOrder_id=1510b98d-3470-11f1-92ef-00249b8cd187
//List all document for a customer
    //php read_document.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187
//List all document for a consignment
    //php read_document.php consignment_id=f57df92f-6513-4f54-a5d6-c4b881460ac1
//Combine filters
    //php read_document.php saleOrder_id=1510b98d-3470-11f1-92ef-00249b8cd187 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 consignment_id=f57df92f-6513-4f54-a5d6-c4b881460ac1