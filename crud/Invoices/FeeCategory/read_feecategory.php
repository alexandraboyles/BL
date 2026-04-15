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
    $feeCategory_name = $_POST['feeCategory_name'] ?? null;

    if ($feeCategory_name === null) {
        throw new InvalidArgumentException(
            'At least one filter is required: feeCategory_name'
        );
    }

    // --------------------------------------------------------
    // Build dynamic WHERE clause
    // --------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($feeCategory_name !== null) {
        $conditions[] = 'astring.feeCategory_name = :feeCategory_name';
        $params[':feeCategory_name'] = $feeCategory_name;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Fee Category
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            astring.appliesTo,
            astring.account,
            astring.feeCategory_name,
            astring.counts_toward_minimum_charges,
            astring.is_name_editable
         FROM feeCategory astring
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

//Run: php read_feeCategory.php feeCategory_name="Tuition Fee"