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

    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $id = $_POST['id'] ?? null; 

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id === null || trim((string)$id) === '') {
        throw new InvalidArgumentException('id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Address exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT id FROM Address WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    $addressUuid = $check->fetchColumn();

    if ($addressUuid === false) {
        throw new RuntimeException('Address does not exist');
    }

    // ---------------------------------------------------------------------
    // FK safety checks (address used elsewhere?)
    // ---------------------------------------------------------------------

    // Consignments
    $check = $pdo->prepare(
        'SELECT 1 FROM Consignment WHERE address_id = :address_uuid LIMIT 1'
    );
    $check->execute([':address_uuid' => $addressUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete address: it is in use by consignments');
    }

    // Address Default Instruction
    $check = $pdo->prepare(
        'SELECT 1 FROM addressDefaultInstruction WHERE address_id = :address_uuid LIMIT 1'
    );
    $check->execute([':address_uuid' => $addressUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete address: it is in use by address default instruction');
    }

    // Address String
    $check = $pdo->prepare(
        'SELECT 1 FROM addressString WHERE address_id = :address_uuid LIMIT 1'
    );
    $check->execute([':address_uuid' => $addressUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete address: it is in use by address string');
    }

    // Address To Delivery Run Mapping
    $check = $pdo->prepare(
        'SELECT 1 FROM addressToDeliveryRunMapping WHERE address_id = :address_uuid LIMIT 1'
    );
    $check->execute([':address_uuid' => $addressUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete address: it is in use by address to delivery run mapping');
    }

    // Delivery Address To Onforwarder Address Mapping
    $check = $pdo->prepare(
        'SELECT 1 FROM deliveryAddressToOnforwarderAddressMapping WHERE address_id = :address_uuid LIMIT 1'
    );
    $check->execute([':address_uuid' => $addressUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete address: it is in use by delivery address to onforwarder address mapping');
    }

    // ---------------------------------------------------------------------
    // Delete Address
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'DELETE FROM Address WHERE id = :id'
    );

    $stmt->execute([
        ':id' => $addressUuid
    ]);

    $pdo->commit();

    echo 'Address deleted successfully. UUID: ' . $addressUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete address: ' . $e->getMessage();
}

//Run: php delete_address.php id=adad3ec5-fe9f-4375-88c5-defbfe042c7f