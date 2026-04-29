<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
}

require __DIR__ . '/../../../db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $id               = $_POST['id'] ?? null; // UUID of location to update
    $location_name    = $_POST['location_name'] ?? null;
    $isle             = $_POST['isle'] ?? null;
    $bay              = $_POST['bay'] ?? null;
    $shelf            = $_POST['shelf'] ?? null;
    $location_type    = $_POST['location_type'] ?? null;
    
    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id=== null || trim($id) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
    }

    foreach ([
        'id'              => $id,
        'location_name'   => $location_name,
        'isle'            => $isle,
        'bay'             => $bay,
        'shelf'           => $shelf,
        'location_type'   => $location_type,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }
    
    // ---------------------------------------------------------------------
    // Ensure Location exists
    // ---------------------------------------------------------------------
    $checkLocation = $pdo->prepare(
        'SELECT 1 FROM location WHERE id = :id'
    );
    $checkLocation->execute([':id' => $id]);

    if ($checkLocation->fetchColumn() === false) {
        throw new RuntimeException('Location does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Location
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE location
         SET
            location_name  = :location_name,
            isle           = :isle,
            bay            = :bay,
            shelf          = :shelf,
            location_type  = :location_type
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'              => $id,
        ':location_name'   => $location_name,
        ':isle'            => $isle,
        ':bay'             => $bay,
        ':shelf'           => $shelf,
        ':location_type'   => $location_type
    ]);

    $pdo->commit();

    echo 'Location updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update location: ' . $e->getMessage();
}

//Run: php update_location.php id=39e6e93b-3bba-4af2-811e-eccba4cced6e location_name="Warehouse A – Cold Storage" isle=A bay="Bay 02" shelf="Shelf 2" location_type="Cold Storage"