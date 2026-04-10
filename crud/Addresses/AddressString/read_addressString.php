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
    $address_id  = $_POST['address_id'] ?? null;   // UUID → Address.id
    $customer_id = $_POST['customer_id'] ?? null;  // UUID → Customer.id

    if ($address_id === null && $customer_id === null) {
        throw new InvalidArgumentException(
            'At least one filter is required: address_id or customer_id'
        );
    }

    // --------------------------------------------------------
    // Build dynamic WHERE clause
    // --------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($address_id !== null) {
        $conditions[] = 'astring.address_id = :address_id';
        $params[':address_id'] = $address_id;
    }

    if ($customer_id !== null) {
        $conditions[] = 'astring.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Address Strings
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            astring.id,
            astring.address_id,
            astring.customer_id,
            astring.text,
            astring.dateAdded,
            astring.lastModified
         FROM addressString astring
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
//Read address strings by address
    //php read_addressString.php address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7
//List all address strings for a customer
    //php read_addressString.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187
//Combine filters
    //php read_addressString.php address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187