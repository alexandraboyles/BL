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
    $id         = $_POST['id']         ?? null; // UUID of Address row
    $address_id = $_POST['address_id'] ?? null;
    $street1    = $_POST['street_1']   ?? null;
    $street2    = $_POST['street_2']   ?? null;
    $suburb     = $_POST['suburb']     ?? null;
    $state      = $_POST['state']      ?? null;
    $postcode   = $_POST['postcode']   ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id === null || trim($id) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
    }

    foreach ([
        'id'         => $id,
        'address_id' => $address_id,
        'street_1'   => $street1,
        'street_2'   => $street2,
        'suburb'     => $suburb,
        'state'      => $state,
        'postcode'   => $postcode,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Address exists
    // ---------------------------------------------------------------------
    $checkAddress = $pdo->prepare(
        'SELECT 1 FROM Address WHERE id = :id'
    );
    $checkAddress->execute([':id' => $id]);

    if ($checkAddress->fetchColumn() === false) {
        throw new RuntimeException('Address does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Address
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Address
         SET
            address_id = :address_id,
            street_1   = :street_1,
            street_2   = :street_2,
            suburb     = :suburb,
            state      = :state,
            postcode   = :postcode
         WHERE id      = :id'
    );

    $stmt->execute([
        'id'           => $id,
        'address_id'   => $address_id,
        ':street_1'    => $street1,
        ':street_2'    => $street2,
        ':suburb'      => $suburb,
        ':state'       => $state,
        ':postcode'    => $postcode,
    ]);

    $pdo->commit();

    echo 'Address updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update address: ' . $e->getMessage();
}

//Run: php update_address.php id=adad3ec5-fe9f-4375-88c5-defbfe042c7f address_id=1002 street_1="Keren St" street_2="Block 1" suburb="Manila" state="MANILA" postcode=6015
