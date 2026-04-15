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
    $id                         = $_POST['id'] ?? null;       // Driver UUID
    $driverName                 = $_POST['driver_name'] ?? null;
    $email                      = $_POST['email'] ?? null;
    $is_online                  = $_POST['is_online'] ?? null;
    $location_access_available  = $_POST['location_access_available'] ?? null;

    if (
        ($id === null || trim($id) === '') &&
        ($driverName === null || trim($driverName) === '') &&
        ($email === null || trim($email) === '')
    ) {
        throw new InvalidArgumentException(
            'At least one filter is required: id, driver_name, or email'
        );
    }

    // -----------------------------------------------------------------
    // Build dynamic query
    // Priority: id > driver_name > email
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {

        $sql = 'SELECT
                    id,
                    driver_name,
                    email,
                    is_online,
                    location_access_available
                FROM Driver
                WHERE id = :id';

        $params = [
            ':id' => $id,
        ];

    } elseif ($driverName !== null && trim($driverName) !== '') {

        $sql = 'SELECT
                    id,
                    driver_name,
                    email,
                    is_online,
                    location_access_available
                FROM Driver
                WHERE driver_name LIKE :driver_name
                ORDER BY driver_name';

        $params = [
            ':driver_name' => '%' . $driverName . '%',
        ];

    } else {
        // contact_email lookup
        $sql = 'SELECT
                    id,
                    driver_name,
                    email,
                    is_online,
                    location_access_available
                FROM Driver
                WHERE email = :email';

        $params = [
            ':email' => $email,
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
            'message' => 'No driver(s) found',
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
//Read driver by UUID
    //php read_driver.php id=2bc93718-971b-487d-b1dd-8fb4f0a0b8ba
//Search drivers by name (partial match)
    //php read_driver.php driver_name=Juan
//Read driver by email
    //php read_driver.php email=juan.updated@gmail.com