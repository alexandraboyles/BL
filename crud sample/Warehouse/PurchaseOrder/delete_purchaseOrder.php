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
    $purchase_order_id = $_POST['purchase_order_id'] ?? null; // business PO id
    $customer_id       = $_POST['customer_id'] ?? null;       // UUID → customer.id

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($purchase_order_id === null || trim((string)$purchase_order_id) === '') {
        throw new InvalidArgumentException('purchase_order_id is required');
    }

    if ($customer_id === null || trim((string)$customer_id) === '') {
        throw new InvalidArgumentException('customer_id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM customer WHERE id = :id'
    );
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Purchase Order exists and belongs to customer
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id, status
         FROM purchaseOrder
         WHERE purchase_order_id = :purchase_order_id
           AND customer_id = :customer_id'
    );

    $stmt->execute([
        ':purchase_order_id' => $purchase_order_id,
        ':customer_id'       => $customer_id
    ]);

    $purchaseOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($purchaseOrder === false) {
        throw new RuntimeException('Purchase order does not exist for this customer');
    }

    $purchaseOrderUuid = $purchaseOrder['id'];

    // ---------------------------------------------------------------------
    // Business rule: prevent delete if already progressed
    // ---------------------------------------------------------------------
    if (strtolower($purchaseOrder['status']) === 'completed') {
        throw new RuntimeException('Cannot delete a completed purchase order');
    }

    // ---------------------------------------------------------------------
    // FK safety: ensure no consignments exist for this PO
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Consignment
         WHERE saleOrder_id = :purchase_order_uuid
         LIMIT 1'
    );
    $check->execute([':purchase_order_uuid' => $purchaseOrderUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException(
            'Cannot delete purchase order: consignments already exist'
        );
    }

    // ---------------------------------------------------------------------
    // Delete Purchase Order
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM purchaseOrder WHERE id = :id'
    );

    $delete->execute([
        ':id' => $purchaseOrderUuid
    ]);

    $pdo->commit();

    echo 'Purchase order deleted successfully. UUID: ' . $purchaseOrderUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete purchase order: ' . $e->getMessage();
}

//Run:
//php delete_purchaseOrder.php purchase_order_id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187