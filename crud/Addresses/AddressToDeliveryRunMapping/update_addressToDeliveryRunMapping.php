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
    $id             = $_POST['id'] ?? null;
    $addressType    = $_POST['addressType'] ?? null;
    $address_id     = $_POST['address_id'] ?? null;     // UUID → Address.id
    $customer_id    = $_POST['customer_id'] ?? null;    // UUID → Customer.id
    $product_id     = $_POST['product_id'] ?? null;     // UUID → Product.id
    $deliveryRun_id = $_POST['deliveryRun_id'] ?? null; // UUID → deliveryRun.id
    $carrier_id     = $_POST['carrier_id'] ?? null;
    $flowDirection  = $_POST['flowDirection'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id' => $id,
        'addressType' => $addressType,
        'address_id' => $address_id,
        'customer_id' => $customer_id,
        'product_id' => $product_id,
        'deliveryRun_id' => $deliveryRun_id,
        'carrier_id' => $carrier_id,
        'flowDirection' => $flowDirection,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure mapping exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM addressToDeliveryRunMapping WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Address to Delivery Run mapping does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Address exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Address WHERE id = :id'
    );
    $check->execute([':id' => $address_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Address does not exist');
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
    // Ensure Carrier exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM carrier WHERE id = :id'
    );
    $check->execute([':id' => $carrier_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Carrier does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Address To Delivery Mapping
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE addressToDeliveryRunMapping
         SET
            addressType    = :addressType,
            address_id     = :address_id,
            customer_id    = :customer_id,
            product_id     = :product_id,
            deliveryRun_id = :deliveryRun_id,
            carrier_id     = :carrier_id,
            flowDirection  = :flowDirection
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'             => $id,
        ':addressType'    => $addressType,
        ':address_id'     => $address_id,
        ':customer_id'    => $customer_id,
        ':product_id'     => $product_id,
        ':deliveryRun_id' => $deliveryRun_id,
        ':carrier_id'     => $carrier_id,
        ':flowDirection'  => $flowDirection
    ]);

    $pdo->commit();

    echo 'Address To Delivery Mapping updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update address to delivery mapping: ' . $e->getMessage();
}

//Run:
//php update_addressToDeliveryRunMapping.php id=1001 addressType=Dropoff address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 product_id=48bd8480-e896-41a1-9343-bc48f585bbf8 deliveryRun_id=a5d49c7e-33d7-11f1-92ef-00249b8cd187 carrier_id=1 flowDirection=-->