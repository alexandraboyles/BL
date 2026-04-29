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
    $address_id     = $_POST['address_id'] ?? null;     // UUID → Address.id
    $customer_id    = $_POST['customer_id'] ?? null;    // UUID → Customer.id
    $product_id     = $_POST['product_id'] ?? null;     // UUID → Product.id
    $deliveryRun_id = $_POST['deliveryRun_id'] ?? null; // UUID → deliveryRun.id
    $carrier_id     = $_POST['carrier_id'] ?? null;

    if (
        $address_id === null &&
        $customer_id === null &&
        $product_id === null &&
        $deliveryRun_id === null &&
        $carrier_id === null
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

    if ($address_id !== null) {
        $conditions[] = 'map.address_id = :address_id';
        $params[':address_id'] = $address_id;
    }

    if ($customer_id !== null) {
        $conditions[] = 'map.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    if ($product_id !== null) {
        $conditions[] = 'map.product_id = :product_id';
        $params[':product_id'] = $product_id;
    }

    if ($deliveryRun_id !== null) {
        $conditions[] = 'map.deliveryRun_id = :deliveryRun_id';
        $params[':deliveryRun_id'] = $deliveryRun_id;
    }

    if ($carrier_id !== null) {
        $conditions[] = 'map.carrier_id = :carrier_id';
        $params[':carrier_id'] = $carrier_id;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Address To Delivery Run Mappings
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            map.id,
            map.addressType,
            map.address_id,
            map.customer_id,
            map.product_id,
            map.deliveryRun_id,
            map.carrier_id,
            map.flowDirection
         FROM addressToDeliveryRunMapping map
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
//Read mappings by address
    //php read_addressToDeliveryRunMapping.php address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7
//List all mappings for a customer
    //php read_addressToDeliveryRunMapping.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187
//Filter by delivery run
    //php read_addressToDeliveryRunMapping.php deliveryRun_id=a5d49c7e-33d7-11f1-92ef-00249b8cd187
//Combine filters
    //php read_addressToDeliveryRunMapping.php address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7 product_id=48bd8480-e896-41a1-9343-bc48f585bbf8
