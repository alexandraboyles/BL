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

require __DIR__ . '/../../db_connect.php';

try {

    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $addressId = $_POST['address_id'] ?? null; // business address_id (INT or VARCHAR)

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($addressId === null || trim((string)$addressId) === '') {
        throw new InvalidArgumentException('address_id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure address exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT id FROM Address WHERE address_id = :address_id'
    );
    $check->execute([':address_id' => $addressId]);

    $addressUuid = $check->fetchColumn();

    if ($addressUuid === false) {
        throw new RuntimeException('Address does not exist');
    }

    // ---------------------------------------------------------------------
    // FK safety checks (address used elsewhere?)
    // ---------------------------------------------------------------------

    // Example: Consignments
    $check = $pdo->prepare(
        'SELECT 1 FROM Consignment WHERE address_id = :address_uuid LIMIT 1'
    );
    $check->execute([':address_uuid' => $addressUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete address: it is in use by consignments');
    }

    // Add more FK checks here if needed
    // e.g. saleOrder, customer, deliveryRun, etc.

    // ---------------------------------------------------------------------
    // Delete address
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

//Run:
//php delete_address.php address_id=12345