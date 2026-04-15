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
    $id               = $_POST['id'] ?? null; // Location UUID
    $location_name    = $_POST['location_name'] ?? null;

    if (
        ($id === null || trim($id) === '') &&
        ($location_name === null || trim($location_name) === '')
    ) {
        throw new InvalidArgumentException(
            'At least one filter is required: id or location_name'
        );
    }

    // -----------------------------------------------------------------
    // Build dynamic query
    // Priority: id > location_name 
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {

        $sql = 'SELECT
                    id,
                    location_name,
                    isle,
                    bay,
                    shelf,
                    location_type
                FROM location
                WHERE id = :id';

        $params = [
            ':id' => $id,
        ];

    } elseif ($location_name !== null && trim($location_name) !== '') {

        $sql = 'SELECT
                    id,
                    location_name,
                    isle,
                    bay,
                    shelf,
                    location_type
                FROM location
                WHERE location_name LIKE :location_name
                ORDER BY location_name';

        $params = [
            ':location_name' => '%' . $location_name . '%',
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
            'message' => 'No location(s) found',
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
//Read location by UUID
    //php read_location.php id=39e6e93b-3bba-4af2-811e-eccba4cced6e
//Search location by name (partial match)
    //php read_location.php location_name="Warehouse A – Cold Storage"