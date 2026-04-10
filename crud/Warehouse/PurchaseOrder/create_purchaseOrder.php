<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
};

require __DIR__ . '/../../../db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $purchase_order_id = $_POST['purchase_order_id'] ?? null;
    $customer_id = $_POST['customer_id'] ?? null; // UUID → customer.id
    $order_reference     = $_POST['order_reference'] ?? null;
    $cust_reference    = $_POST['cust_reference'] ?? null;
    $ship_name  = $_POST['ship_name'] ?? null;
    $ship_address     = $_POST['ship_address'] ?? null;
    $status = $_POST['status'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'purchase_order_id' => $purchase_order_id,
        'customer_id'        => $customer_id,
        'order_reference'  => $order_reference,
        'cust_reference'  => $cust_reference,
        'ship_name'  => $ship_name,
        'ship_address'  => $ship_address,
        'status'  => $status
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
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
    // Generate a UUID version 4 (random UUID)
    // Matches CHAR(36): xxxxxxxx-xxxx-4xxx-8xxx-xxxxxxxxxxxx
    // ---------------------------------------------------------------------

    $uuid = sprintf(
    // Format: 8-4-4-4-12 hexadecimal characters (36 chars including hyphens)
    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

    // First 8 hex characters (32 bits of randomness)
    random_int(0, 0xffff), // 4 hex chars
    random_int(0, 0xffff), // 4 hex chars

    // Next 4 hex characters (16 bits of randomness)
    random_int(0, 0xffff),

    // UUID version field (4 = UUID v4)
    // - random_int(0, 0x0fff) gives 12 random bits
    // - OR with 0x4000 forces the version bits to '0100' (v4)
    random_int(0, 0x0fff) | 0x4000,

    // UUID variant field (RFC 4122 compliant)
    // - random_int(0, 0x3fff) gives 14 random bits
    // - OR with 0x8000 forces the variant bits to '10xx'
    random_int(0, 0x3fff) | 0x8000,

    // Final 12 hex characters (48 bits of randomness)
    random_int(0, 0xffff), // 4 hex chars
    random_int(0, 0xffff), // 4 hex chars
    random_int(0, 0xffff)  // 4 hex chars
    );

    // ---------------------------------------------------------------------
    // Insert Purchase Order
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO PurchaseOrder (
            id,
            purchase_order_id,
            customer_id,
            order_reference,
            cust_reference,
            ship_name,
            ship_address,
            status
        ) VALUES (
            :id,
            :purchase_order_id,
            :customer_id,
            :order_reference,
            :cust_reference,
            :ship_name,
            :ship_address,
            :status
        )'
    );

    $stmt->execute([
        ':id'          => $uuid,
        ':purchase_order_id'          => $purchase_order_id,
        ':customer_id' => $customer_id,
        ':order_reference'       => $order_reference,
        ':cust_reference'       => $cust_reference,
        ':ship_name'       => $ship_name,
        ':ship_address'       => $ship_address,
        ':status'       => $status
    ]);

    $pdo->commit();

    echo 'Purchase Order created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create purchase order: ' . $e->getMessage();
};


//Run: php create_purchaseOrder.php purchase_order_id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 order_reference=WEB-ORDER-77821 cust_reference=CUST-REF-9912 ship_name=Alexandra Boyles ship_address=123 Rizal Street,Barangay Poblacion,Talisay City,Cebu,Philippines status=pending