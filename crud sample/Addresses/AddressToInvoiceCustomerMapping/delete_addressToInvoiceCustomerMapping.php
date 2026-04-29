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
    $id = $_POST['id'] ?? null; // addressToInvoiceCustomerMapping.id

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
        'SELECT 1 FROM addressToInvoiceCustomerMapping WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException(
            'Address to Invoice Customer mapping does not exist'
        );
    }

    // ---------------------------------------------------------------------
    // Delete Address To Invoice Customer Mapping
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'DELETE FROM addressToInvoiceCustomerMapping WHERE id = :id'
    );

    $stmt->execute([
        ':id' => $id
    ]);

    $pdo->commit();

    echo 'Address To Invoice Customer Mapping deleted successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete address to invoice customer mapping: '
        . $e->getMessage();
}

//Run: php delete_addressToInvoiceCustomerMapping.php id=1001