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
    $id          = $_POST['id'] ?? null;
    $customer_id = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $address_id  = $_POST['address_id'] ?? null;  // UUID → Address.id
    $product_id  = $_POST['product_id'] ?? null;  // UUID → Product.id

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id' => $id,
        'customer_id' => $customer_id,
        'address_id' => $address_id,
        'product_id' => $product_id,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure mapping exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM deliveryAddressToOnforwarderAddressMapping WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException(
            'Delivery Address To Onforwarder Address Mapping does not exist'
        );
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
        'SELECT 1 FROM Product WHERE id = :id'
    );
    $check->execute([':id' => $product_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Product does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Delivery Address To Onforwarder Address Mapping
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE deliveryAddressToOnforwarderAddressMapping
         SET
             customer_id = :customer_id,
             address_id  = :address_id,
             product_id  = :product_id
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'          => $id,
        ':customer_id' => $customer_id,
        ':address_id'  => $address_id,
        ':product_id'  => $product_id
    ]);

    $pdo->commit();

    echo 'Delivery Address To Onforwarder Address Mapping updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update delivery address to onforwarder address mapping: '
        . $e->getMessage();
};

//Run: php update_deliveryAddressToOnforwarderAddressMapping.php id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7 product_id=702ed0e8-fbca-409e-9d15-7548c10f0ad3