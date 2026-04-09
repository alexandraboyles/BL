<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
}

require __DIR__ . '/../../db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $uuid      = $_POST['id']         ?? null; // UUID of Address row
    $street1   = $_POST['street_1']   ?? null;
    $street2   = $_POST['street_2']   ?? null;
    $suburb    = $_POST['suburb']     ?? null;
    $state     = $_POST['state']      ?? null;
    $postcode  = $_POST['postcode']   ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($uuid === null || trim($uuid) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
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

    // ---------------------------------------------------------------------
    // Update
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Address
         SET
            street_1 = :street_1,
            street_2 = :street_2,
            suburb   = :suburb,
            state    = :state,
            postcode = :postcode
         WHERE id = :id'
    );

    $stmt->execute([
        ':street_1' => $street1,
        ':street_2' => $street2,
        ':suburb'   => $suburb,
        ':state'    => $state,
        ':postcode' => $postcode,
        ':id'       => $uuid,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('No address found with the given id');
    }

    $pdo->commit();

    echo 'Address updated successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update address: ' . $e->getMessage();
}

//Run: php update_address.php id=adad3ec5-fe9f-4375-88c5-defbfe042c7f street_1="Velez St" street_2="Unit 18" suburb="Cebu" state="CEB" postcode=6000
