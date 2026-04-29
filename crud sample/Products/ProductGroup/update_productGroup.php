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
require __DIR__ . '/../../../config/db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $id                        = $_POST['id'] ?? null;
    $customer_id               = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $productType_id            = $_POST['productType_id'] ?? null;
    $productGroup_name         = $_POST['productGroup_name'] ?? null;
    $productGroup_description  = $_POST['productGroup_description'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id'                        => $id,
        'customer_id'               => $customer_id,
        'productType_id'            => $productType_id,
        'productGroup_name'         => $productGroup_name,
        'productGroup_description'  => $productGroup_description,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Product Group exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM productGroup WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Product Group does not exist');
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
    // Update Address To Delivery Mapping
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
       'UPDATE productGroup
        SET
        customer_id              = :customer_id,
        productType_id           = :productType_id,
        productGroup_name        = :productGroup_name,
        productGroup_description = :productGroup_description
        WHERE id = :id'
    );

    $stmt->execute([
        ':id'                        => $id,
        ':customer_id'               => $customer_id,
        ':productType_id'            => $productType_id,
        ':productGroup_name'         => $productGroup_name,
        ':productGroup_description'  => $productGroup_description
    ]);

    $pdo->commit();

    echo 'Product Group updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update product group: ' . $e->getMessage();
}

//Run: php update_productGroup.php id=1 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 productType_id=1 productGroup_name=Test productGroup_description="Test test updated"