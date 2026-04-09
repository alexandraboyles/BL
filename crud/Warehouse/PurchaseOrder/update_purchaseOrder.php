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
    $id                 = $_POST['id'] ?? null;              // UUID → purchaseOrder.id
    $purchase_order_id  = $_POST['purchase_order_id'] ?? null;
    $customer_id        = $_POST['customer_id'] ?? null;
    $order_reference    = $_POST['order_reference'] ?? null;
    $cust_reference     = $_POST['cust_reference'] ?? null;
    $ship_name          = $_POST['ship_name'] ?? null;
    $ship_address       = $_POST['ship_address'] ?? null;
    $status             = $_POST['status'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id'                => $id,
        'purchase_order_id' => $purchase_order_id,
        'customer_id'       => $customer_id,
        'order_reference'   => $order_reference,
        'cust_reference'    => $cust_reference,
        'ship_name'         => $ship_name,
        'ship_address'      => $ship_address,
        'status'            => $status,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Purchase Order exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM purchaseOrder WHERE id = :id');
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Purchase Order does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM customer WHERE id = :id');
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Purchase Order
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE purchaseOrder SET
            purchase_order_id = :purchase_order_id,
            customer_id       = :customer_id,
            order_reference   = :order_reference,
            cust_reference    = :cust_reference,
            ship_name         = :ship_name,
            ship_address      = :ship_address,
            status            = :status
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'                => $id,
        ':purchase_order_id' => $purchase_order_id,
        ':customer_id'       => $customer_id,
        ':order_reference'   => $order_reference,
        ':cust_reference'    => $cust_reference,
        ':ship_name'         => $ship_name,
        ':ship_address'      => $ship_address,
        ':status'            => $status,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('No changes were applied');
    }

    $pdo->commit();

    echo 'Purchase Order updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update purchase order: ' . $e->getMessage();
}

//Run: php update_purchaseOrder.php id=6e59821b-ebc0-45d6-9880-d7d9dd9da5d8 purchase_order_id=1002 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 order_reference=WEB-ORDER-77821 cust_reference=CUST-REF-9912 ship_name="Alexandra Boyles" ship_address="123 Rizal Street, Barangay Poblacion, Talisay City, Cebu, Philippines" status=pending