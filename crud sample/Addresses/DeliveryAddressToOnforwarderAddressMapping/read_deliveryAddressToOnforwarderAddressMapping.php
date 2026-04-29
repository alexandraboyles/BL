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
    $id          = $_POST['id'] ?? null;          // Mapping ID
    $customer_id = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $address_id  = $_POST['address_id'] ?? null;  // UUID → Address.id
    $product_id  = $_POST['product_id'] ?? null;  // UUID → Product.id

    if (
        $id === null &&
        $customer_id === null &&
        $address_id === null &&
        $product_id === null
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

    if ($id !== null) {
        $conditions[] = 'map.id = :id';
        $params[':id'] = $id;
    }

    if ($customer_id !== null) {
        $conditions[] = 'map.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    if ($address_id !== null) {
        $conditions[] = 'map.address_id = :address_id';
        $params[':address_id'] = $address_id;
    }

    if ($product_id !== null) {
        $conditions[] = 'map.product_id = :product_id';
        $params[':product_id'] = $product_id;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Delivery Address To Onforwarder Address Mappings
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            map.id,
            map.customer_id,
            map.address_id,
            map.product_id
         FROM deliveryAddressToOnforwarderAddressMapping map
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
//Read by mapping ID
    //php read_deliveryAddressToOnforwarderAddressMapping.php id=1001
//Read by customer
    //php read_deliveryAddressToOnforwarderAddressMapping.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187
//Read by address
    //php read_deliveryAddressToOnforwarderAddressMapping.php address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7
//Read by product
    //php read_deliveryAddressToOnforwarderAddressMapping.php product_id=702ed0e8-fbca-409e-9d15-7548c10f0ad3
//Combine filters
    //php read_deliveryAddressToOnforwarderAddressMapping.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 product_id=702ed0e8-fbca-409e-9d15-7548c10f0ad3