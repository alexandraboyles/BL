<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
};

require __DIR__ . '/../../../db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $location_name   = $_POST['location_name'] ?? null;
    $isle            = $_POST['isle'] ?? null;
    $bay             = $_POST['bay'] ?? null;
    $shelf           = $_POST['shelf'] ?? null;
    $location_type   = $_POST['location_type'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
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
    // Generate a UUID version 4 (random UUID)
    // Matches CHAR(36): xxxxxxxx-xxxx-4xxx-8xxx-xxxxxxxxxxxx
    // ---------------------------------------------------------------------

    $uuid = sprintf(
    // Format: 8-4-4-4-12 hexadecimal characters (36 chars including hyphens)
    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

    // First 8 hex characters (32 bits of randomness)
    random_int(0, 0xffff), // 4 hex chars
    random_int(0, 0xffff), // 4 hex chars

    // Next 4 hex characters (16 bits of randomness)
    random_int(0, 0xffff),

    // UUID version field (4 = UUID v4)
    // - random_int(0, 0x0fff) gives 12 random bits
    // - OR with 0x4000 forces the version bits to '0100' (v4)
    random_int(0, 0x0fff) | 0x4000,

    // UUID variant field (RFC 4122 compliant)
    // - random_int(0, 0x3fff) gives 14 random bits
    // - OR with 0x8000 forces the variant bits to '10xx'
    random_int(0, 0x3fff) | 0x8000,

    // Final 12 hex characters (48 bits of randomness)
    random_int(0, 0xffff), // 4 hex chars
    random_int(0, 0xffff), // 4 hex chars
    random_int(0, 0xffff)  // 4 hex chars
    );

    // ---------------------------------------------------------------------
    // Insert Location
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO location (
            id,
            location_name,
            isle,
            bay,
            shelf,
            location_type
        ) VALUES (
            :id,
            :location_name,
            :isle,
            :bay,
            :shelf,
            :location_type
        )'
    );

    $stmt->execute([
        ':id'            => $uuid,
        ':location_name' => $location_name,
        ':isle'          => $isle,
        ':bay'           => $bay,
        ':shelf'         => $shelf,
        ':location_type' => $location_type
    ]);

    $pdo->commit();

    echo 'Location created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create location: ' . $e->getMessage();
};


//Run: php create_location.php location_name="Warehouse A – General Storage" isle=A bay="Bay 01" shelf="Shelf 1" location_type=Storage
 
//  'Warehouse A – Cold Storage',
//  'A',
//  'Bay 02',
//  'Shelf 3',
//  'Cold Storage'),
