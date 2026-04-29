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
    $id = $_POST['id'] ?? null; 

    // -----------------------------------------------------------------
    // Validate input
    // -----------------------------------------------------------------
    if ($id === null || trim($id) === '') {
        throw new InvalidArgumentException('id is required');
    }

    // -----------------------------------------------------------------
    // Ensure Driver exists
    // -----------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id FROM Driver WHERE id = :id'
    );
    $stmt->execute([':id' => $id]);
    
    $driverUuid = $stmt->fetchColumn();

    if ($driverUuid === false) {
        throw new RuntimeException('Driver does not exist');
    }

    // ---------------------------------------------------------------------
    // FK safety checks (driver used elsewhere?)
    // ---------------------------------------------------------------------

    // Consignment
    $check = $pdo->prepare(
        'SELECT 1 FROM Consignment WHERE driver_id = :driver_uuid LIMIT 1'
    );
    $check->execute([':driver_uuid' => $driverUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete driver: it is in use by consignment');
    }

    // Run Sheet
    $check = $pdo->prepare(
        'SELECT 1 FROM runsheet WHERE driver_id = :driver_uuid LIMIT 1'
    );
    $check->execute([':driver_uuid' => $driverUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete driver: it is in use by runsheet');
    }

    // -----------------------------------------------------------------
    // Delete Driver
    // -----------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM Driver WHERE id = :id'
    );

    $delete->execute([
        ':id' => $driverUuid,
    ]);

    $pdo->commit();

    echo 'Driver deleted successfully. UUID: ' . $driverUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete driver: ' . $e->getMessage();
}

//Run: php delete_driver.php id=9bb4f573-8307-4ed5-b2dd-e176455ecd18