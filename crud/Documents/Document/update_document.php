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
    $id = $_POST['id'] ?? null; // document.id
    $saleOrder_id = $_POST['saleOrder_id'] ?? null; // SaleOrder.id
    $customer_id = $_POST['customer_id'] ?? null; // Customer.id
    $consignment_id = $_POST['consignment_id'] ?? null; // Consignment.id
    $fileType  = $_POST['fileType'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id' => $id,
        'saleOrder_id' => $saleOrder_id,
        'customer_id' => $customer_id,
        'consignment_id' => $consignment_id,
        'fileType' => $fileType,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
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
    // Ensure Customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Customer WHERE id = :id'
    );
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Consignment exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Consignment WHERE id = :id'
    );
    $check->execute([':id' => $consignment_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Consignment does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Document
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE document
         SET
            saleOrder_id  = :saleOrder_id,
            customer_id = :customer_id,
            consignment_id = :consignment_id,
            fileType  = :fileType
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'          => $id,
        ':saleOrder_id'   => $saleOrder_id,
        ':customer_id' => $customer_id,
        ':consignment_id' => $consignment_id,
        ':fileType' => $fileType,
    ]);

    $pdo->commit();

    echo 'Document updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update document: ' . $e->getMessage();
}

//Run: php update_document.php id=1001 saleOrder_id=1510b98d-3470-11f1-92ef-00249b8cd187 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 consignment_id=f57df92f-6513-4f54-a5d6-c4b881460ac1 fileType=ZIP