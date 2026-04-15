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
    $consignment_id = $_POST['consignment_id'] ?? null; // business consignment id
    $saleOrder_id   = $_POST['saleOrder_id'] ?? null;   // UUID

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($consignment_id === null || trim((string)$consignment_id) === '') {
        throw new InvalidArgumentException('consignment_id is required');
    }

    if ($saleOrder_id === null || trim((string)$saleOrder_id) === '') {
        throw new InvalidArgumentException('saleOrder_id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Sale Order exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM saleOrder WHERE id = :id'
    );
    $check->execute([':id' => $saleOrder_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Sale Order does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure consignment exists and belongs to sale order
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM Consignment
         WHERE consignment_id = :consignment_id
           AND saleOrder_id = :saleOrder_id'
    );

    $stmt->execute([
        ':consignment_id' => $consignment_id,
        ':saleOrder_id'   => $saleOrder_id
    ]);

    $consignmentUuid = $stmt->fetchColumn();

    if ($consignmentUuid === false) {
        throw new RuntimeException('Consignment does not exist for this sale order');
    }

    // ---------------------------------------------------------------------
    // Business rule: prevent deletion if linked to invoicing
    // (adjust/remove if your system allows it)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Invoice WHERE manifest_id = :consignment_uuid LIMIT 1'
    );
    $check->execute([':consignment_uuid' => $consignmentUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete consignment: it has been invoiced');
    }

    // ---------------------------------------------------------------------
    // Delete consignment
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM Consignment WHERE id = :id'
    );

    $delete->execute([
        ':id' => $consignmentUuid
    ]);

    $pdo->commit();

    echo 'Consignment deleted successfully. UUID: ' . $consignmentUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete consignment: ' . $e->getMessage();
}

//Run:
//php delete_consignment.php consignment_id=1002 saleOrder_id=1510b98d-3470-11f1-92ef-00249b8cd187