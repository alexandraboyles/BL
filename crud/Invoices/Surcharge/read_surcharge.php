<?php
declare(strict_types=1);

// ---------------------------------------------------------------------
// CLI support
// ---------------------------------------------------------------------
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_REQUEST = array_merge($_REQUEST, $parsed);
    }
}

require __DIR__ . '/../../../db_connect.php';

try {

    // -----------------------------------------------------------------
    // Collect input
    // -----------------------------------------------------------------
    $feeCategory_id = $_REQUEST['feeCategory_id'] ?? null;
    $surcharge_name = $_REQUEST['surcharge_name'] ?? null;
    $condition_text = $_REQUEST['conditions'] ?? null;
    $surcharge      = $_REQUEST['surcharge'] ?? null;
    $status         = $_REQUEST['status'] ?? null;

    // -----------------------------------------------------------------
    // Build dynamic WHERE clause
    // -----------------------------------------------------------------
    $where = [];
    $params = [];

    if ($feeCategory_id !== null) {
        $where[] = 's.feeCategory_id = :feeCategory_id';
        $params[':feeCategory_id'] = $feeCategory_id;
    }

    if ($surcharge_name !== null) {
        $where[] = 's.surcharge_name = :surcharge_name';
        $params[':surcharge_name'] = $surcharge_name;
    }

    if ($condition_text !== null) {
        $where[] = 's.conditions = :conditions';
        $params[':conditions'] = $condition_text;
    }

    if ($surcharge !== null) {
        $where[] = 's.surcharge = :surcharge';
        $params[':surcharge'] = $surcharge;
    }

    if ($status !== null) {
        $where[] = 's.status = :status';
        $params[':status'] = $status;
    }

    if (!$where) {
        throw new InvalidArgumentException('At least one filter parameter is required.');
    }

    $whereSql = implode(' AND ', $where);

    // -----------------------------------------------------------------
    // Query
    // -----------------------------------------------------------------
    $sql = "
        SELECT
            s.feeCategory_id,
            f.feeCategory_name,
            s.surcharge_name,
            s.conditions,
            s.surcharge,
            s.status
        FROM surcharge s
        JOIN feeCategory f ON f.id = s.feeCategory_id
        WHERE {$whereSql}
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'count'   => count($rows),
        'data'    => $rows
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

//Run:
//Read single surcharge by surcharge name
    //php read_surcharge.php surcharge_name="Late Payment Surcharge"
//List all surcharges for a fee category
    //php read_surcharge.php feeCategory_id=1 status=Active