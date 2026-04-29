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
    $customer_id = $_POST['customer_id'] ?? null; // Customer.id

    if ($customer_id === null) {
        throw new InvalidArgumentException(
            'At least one filter is required: customer_id'
        );
    }

    // --------------------------------------------------------
    // Build dynamic WHERE clause
    // --------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($customer_id !== null) {
        $conditions[] = 'astring.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Rate Card
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            astring.id,
            astring.customer_id,
            astring.rates,
            astring.contact_email
         FROM rateCard astring
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

//Run: php read_rateCard.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187