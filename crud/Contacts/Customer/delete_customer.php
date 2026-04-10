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

    // -----------------------------------------------------------------
    // Collect input
    // -----------------------------------------------------------------
    $id = $_POST['id'] ?? null; 

    // -----------------------------------------------------------------
    // Validate input
    // -----------------------------------------------------------------
    if ($id === null || trim((string)$id) === '') {
        throw new InvalidArgumentException("id is required");
    }

    // -----------------------------------------------------------------
    // Ensure Customer exists
    // -----------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM Customer
         WHERE id = :id'
    );

    $stmt->execute([':id' => $id]);

    $customerUuid = $stmt->fetchColumn();

    if ($customerUuid === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // FK safety checks (customer used elsewhere?)
    // ---------------------------------------------------------------------

    // Address Default Instruction
    $check = $pdo->prepare(
        'SELECT 1 FROM addressDefaultInstruction WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by address default instruction');
    }

    // Address String
    $check = $pdo->prepare(
        'SELECT 1 FROM addressString WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by address string');
    }

    // Address To Delivery Run Mapping
    $check = $pdo->prepare(
        'SELECT 1 FROM addressToDeliveryRunMapping WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by address to delivery run mapping');
    }

    // Delivery Address To Onforwarder Address Mapping
    $check = $pdo->prepare(
        'SELECT 1 FROM deliveryAddressToOnforwarderAddressMapping WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by delivery address to onforwarder address mapping');
    }

    // Contact
    $check = $pdo->prepare(
        'SELECT 1 FROM Contact WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by contact');
    }

    // Invoice
    $check = $pdo->prepare(
        'SELECT 1 FROM Invoice WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by invoice');
    }

    // Rate Card
    $check = $pdo->prepare(
        'SELECT 1 FROM rateCard WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by rate card');
    }

    // Manifest
    $check = $pdo->prepare(
        'SELECT 1 FROM manifest WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by manifest');
    }

    // Product
    $check = $pdo->prepare(
        'SELECT 1 FROM Product WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by product');
    }

    // Sale Order
    $check = $pdo->prepare(
        'SELECT 1 FROM saleOrder WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by sale order');
    }

    // Purchase Order
    $check = $pdo->prepare(
        'SELECT 1 FROM PurchaseOrder WHERE customer_id = :customer_uuid LIMIT 1'
    );
    $check->execute([':customer_uuid' => $customerUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete customer: it is in use by purchase order');
    }

    // -----------------------------------------------------------------
    // Delete customer
    // -----------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM Customer WHERE id = :id'
    );

    $delete->execute([
        ':id' => $customerUuid,
    ]);

    $pdo->commit();

    echo 'Customer deleted successfully. UUID: ' . $customerUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete customer: ' . $e->getMessage();
}

//Run: php delete_customer.php id=64ed8b3e-3247-11f1-92ef-00249b8cd187