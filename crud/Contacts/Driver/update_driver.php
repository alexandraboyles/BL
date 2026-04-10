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
    $id          = $_POST['id'] ?? null; // UUID of driver to update
    $driver_name   = $_POST['driver_name'] ?? null; 
    $email      = $_POST['email'] ?? null;
    $is_online  = $_POST['is_online'] ?? null;
    $location_access_available  = $_POST['location_access_available'] ?? null;

    // -----------------------------------------------------------------
    // Validate input
    // -----------------------------------------------------------------
    if ($id === null || trim($id) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
    }

    foreach ([
        'id'              => $id,
        'driver_name' => $driver_name,
        'email'       => $email,
        'is_online'   => $is_online,
        'location_access_available' => $location_access_available,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // -----------------------------------------------------------------
    // Ensure Driver exists
    // -----------------------------------------------------------------
    $checkDriver = $pdo->prepare(
        'SELECT 1 FROM Driver WHERE id = :id'
    );
    $checkDriver->execute([':id' => $id]);

    if ($checkDriver->fetchColumn() === false) {
        throw new RuntimeException('Driver does not exist');
    }

    // -----------------------------------------------------------------
    // Update Driver
    // -----------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Driver
         SET
            driver_name = :driver_name,
            email = :email,
            is_online = :is_online,
            location_access_available =:location_access_available
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'          => $id,
        ':driver_name'   => $driver_name,
        ':email'   => $email,
        ':is_online'   => $is_online,
        ':location_access_available'   => $location_access_available,
    ]);

    $pdo->commit();

    echo 'Driver updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update driver: ' . $e->getMessage();
}

//Run: php update_driver.php id=333e8400-e29b-41d4-a716-333333333333 driver_name=Juan Dela Cruz email=juan.updated@gmail.com is_online=0 location_access_available=1