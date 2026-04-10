<?php
declare(strict_types=1);

// ------------------------------------------------------------
// Allow CLI arguments like key=value&key2=value2
// ------------------------------------------------------------
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
    $id = $_POST['id'] ?? null; // deliveryAddressToOnforwarderAddressMapping.id

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id === null || trim($id) === '') {
        throw new InvalidArgumentException('id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure mapping exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1
         FROM deliveryAddressToOnforwarderAddressMapping
         WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException(
            'Delivery Address To Onforwarder Address Mapping does not exist'
        );
    }

    // ---------------------------------------------------------------------
    // Delete Delivery Address To Onforwarder Address Mapping
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'DELETE FROM deliveryAddressToOnforwarderAddressMapping
         WHERE id = :id'
    );

    $stmt->execute([
        ':id' => $id
    ]);

    $pdo->commit();

    echo 'Delivery Address To Onforwarder Address Mapping deleted successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete delivery address to onforwarder address mapping: '
        . $e->getMessage();
}

//Run: php delete_deliveryAddressToOnforwarderAddressMapping.php id=1001