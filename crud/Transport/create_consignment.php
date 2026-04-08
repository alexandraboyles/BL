<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
};

require __DIR__ . '/../../db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $consignment_id = $_POST['consignment_id'] ?? null;
    $saleOrder_id = $_POST['saleOrder_id'] ?? null; // UUID → saleOrder.id
    $address_id = $_POST['address_id'] ?? null; // UUID → address.id
    $product_id = $_POST['product_id'] ?? null; // UUID → product.id
    $deliveryRun_id = $_POST['deliveryRun_id'] ?? null; // UUID → deliveryRun.id
    $driver_id = $_POST['driver_id'] ?? null; // UUID → driver.id
    $runsheet_id = $_POST['runsheet_id'] ?? null;
    $service     = $_POST['service'] ?? null;
    $reference    = $_POST['reference'] ?? null;
    $is_residential  = $_POST['is_residential'] ?? null;
    $quantity     = $_POST['quantity'] ?? null;
    $cubic       = $_POST['cubic'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $pallets = $_POST['pallets'] ?? null;
    $spaces = $_POST['spaces'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'consignment_id' => $consignment_id,
        'saleOrder_id'        => $saleOrder_id,
        'address_id'       => $address_id,
        'product_id'       => $product_id,
        'deliveryRun_id'       => $deliveryRun_id,
        'driver_id'       => $driver_id,
        'runsheet_id'       => $runsheet_id,
        'service'  => $service,
        'reference'  => $reference,
        'is_residential'  => $is_residential,
        'quantity'  => $quantity,
        'cubic'  => $cubic,
        'weight'  => $weight,
        'pallets'  => $pallets,
        'spaces'  => $spaces,
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
    // Ensure Address exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM address WHERE id = :id'
    );
    $check->execute([':id' => $address_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Address does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Product exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM product WHERE id = :id'
    );
    $check->execute([':id' => $product_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Product does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Delivery Run exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM deliveryRun WHERE id = :id'
    );
    $check->execute([':id' => $deliveryRun_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Delivery Run does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Driver exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM driver WHERE id = :id'
    );
    $check->execute([':id' => $driver_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Driver does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Run Sheet exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM runsheet WHERE id = :id'
    );
    $check->execute([':id' => $runsheet_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Run Sheet does not exist');
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
    // Insert Consignment
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO Consignment (
            id,
            consignment_id,
            saleOrder_id,
            address_id,
            product_id,
            deliveryRun_id,
            driver_id,
            runsheet_id,
            service,
            reference,
            is_residential,
            quantity,
            cubic,
            weight,
            pallets,
            spaces
        ) VALUES (
            :id,
            :consignment_id,
            :saleOrder_id,
            :address_id,
            :product_id,
            :deliveryRun_id,
            :driver_id,
            :runsheet_id,
            :service,
            :reference,
            :is_residential,
            :quantity,
            :cubic,
            :weight,
            :pallets,
            :spaces
        )'
    );

    $stmt->execute([
        ':id'          => $uuid,
        ':consignment_id'          => $consignment_id,
        ':saleOrder_id' => $saleOrder_id,
        ':address_id'        => $address_id,
        ':product_id'       => $product_id,
        ':deliveryRun_id'       => $deliveryRun_id,
        ':driver_id'       => $driver_id,
        ':runsheet_id'       => $runsheet_id,
        ':service'       => $service,
        ':reference'       => $reference,
        ':is_residential'       => $is_residential,
        ':quantity'       => $quantity,
        ':cubic'       => $cubic,
        ':weight'       => $weight,
        ':pallets'       => $pallets,
        ':spaces'       => $spaces
    ]);

    $pdo->commit();

    echo 'Consignment created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create consignment: ' . $e->getMessage();
};


//Run: php create_consignment.php consignment_id=1001 saleOrder_id=550e8400-e29b-41d4-a716-446655440000 address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7 product_id=9afd51f5-06a1-45d9-a3d5-d7b8c6f77f35 deliveryRun_id=222e8400-e29b-41d4-a716-222222222222 driver_id=333e8400-e29b-41d4-a716-333333333333 runsheet_id=1 service=Standard Delivery reference=PO-456789 is_residential=1 quantity=10 cubic=2.45 weight=350.75 pallets=1 spaces=2