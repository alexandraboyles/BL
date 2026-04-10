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
    $id          = $_POST['id'] ?? null;          // Mapping ID
    $customer_id = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $address_id  = $_POST['address_id'] ?? null;  // UUID → Address.id

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id' => $id,
        'customer_id' => $customer_id,
        'address_id' => $address_id,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure mapping exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM addressToInvoiceCustomerMapping WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Address to Invoice Customer Mapping does not exist');
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
    // Update Address To Invoice Customer Mapping
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE addressToInvoiceCustomerMapping
         SET
             customer_id = :customer_id,
             address_id  = :address_id
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'          => $id,
        ':customer_id' => $customer_id,
        ':address_id'  => $address_id,
    ]);

    $pdo->commit();

    echo 'Address To Invoice Customer Mapping updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update address to invoice customer mapping: ' . $e->getMessage();
}

//Run: php update_addressToInvoiceCustomerMapping.php id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 address_id=adad3ec5-fe9f-4375-88c5-defbfe042c7