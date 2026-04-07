<?php
declare(strict_types=1);
// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
};

require __DIR__ . '/../../db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $addressId = $_POST['address_id'] ?? null;
    $street1   = $_POST['street_1']   ?? null;
    $street2   = $_POST['street_2']   ?? null;
    $suburb    = $_POST['suburb']     ?? null;
    $state     = $_POST['state']      ?? null;
    $postcode  = $_POST['postcode']   ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    if ($addressId === null || $addressId === '' || !ctype_digit((string)$addressId)) {
        throw new InvalidArgumentException('address_id is required and must be an integer');
    }

    foreach ([
        'street_1' => $street1,
        'street_2' => $street2,
        'suburb'   => $suburb,
        'state'    => $state,
        'postcode' => $postcode,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    $addressId = (int) $addressId;

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
    // Insert
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO Address (
            id,
            address_id,
            street_1,
            street_2,
            suburb,
            state,
            postcode
        ) VALUES (
            :id,
            :address_id,
            :street_1,
            :street_2,
            :suburb,
            :state,
            :postcode
        )'
    );

    $stmt->execute([
        ':id'         => $uuid,
        ':address_id' => $addressId,
        ':street_1'   => $street1,
        ':street_2'   => $street2,
        ':suburb'     => $suburb,
        ':state'      => $state,
        ':postcode'   => $postcode,
    ]);

    $pdo->commit();

    echo 'Address created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create address: ' . $e->getMessage();
};


//Run: php create_address.php address_id=1002&street_1=Velez St&street_2=Unit 15&suburb=Cebu&state=CEB&postcode=6000 