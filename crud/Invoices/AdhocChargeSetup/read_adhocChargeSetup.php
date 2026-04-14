<?php
declare(strict_types=1);

// ---------------------------------------------------------------------
// Allow CLI arguments like key=value&key2=value2
// ---------------------------------------------------------------------
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
}

require __DIR__ . '/../../../db_connect.php';

try {
    // -----------------------------------------------------------------
    // Collect input
    // -----------------------------------------------------------------
    $id      = $_POST['id'] ?? null;    // adhocChargeSetup.id
    $adhocChargeSetup_name  = $_POST['adhocChargeSetup_name'] ?? null;

    if (
        ($id === null || trim($id) === '') &&
        ($adhocChargeSetup_name === null || trim($adhocChargeSetup_name) === '')
    ) {
        throw new InvalidArgumentException(
            'At least one filter is required: id or adhocChargeSetup'
        );
    }

    // -----------------------------------------------------------------
    // Build dynamic query
    // Priority: id > adhocChargeSetup
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {

        $sql = '
            SELECT
                id,
                adhocChargeSetup_name,
                chargeStructure,
                rate,
                descriptionTemplate,
                is_enabled,
                pageVisionOn
            FROM adhocChargeSetup
            WHERE id = :id
        ';

        $params = [
            ':id' => $id,
        ];

    } else {
        // adhocChargeSetup filter
        $sql = 'SELECT
                id,
                adhocChargeSetup_name,
                chargeStructure,
                rate,
                descriptionTemplate,
                is_enabled,
                pageVisionOn
            FROM adhocChargeSetup
            WHERE adhocChargeSetup_name = :adhocChargeSetup_name';

        $params = [
            ':adhocChargeSetup_name' => $adhocChargeSetup_name,
        ];
    }

    // -----------------------------------------------------------------
    // Execute
    // -----------------------------------------------------------------
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // -----------------------------------------------------------------
    // Output
    // -----------------------------------------------------------------
    if (!$rows) {
        echo json_encode([
            'success' => true,
            'data'    => [],
            'message' => 'No adhoc charge setup(s) found',
        ], JSON_PRETTY_PRINT);
        exit;
    }

    echo json_encode([
        'success' => true,
        'data'    => $rows,
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    header('Content-Type: application/json', true, 400);

    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage(),
    ], JSON_PRETTY_PRINT);
}

//Run: 
//Read adhoc charge setup by ID
    //php read_adhocChargeSetup.php id=1001
//Lookup supplier by adhocChargeSetup_name
    //php read_adhocChargeSetup.php adhocChargeSetup_name="Late Payment Fee Updated"