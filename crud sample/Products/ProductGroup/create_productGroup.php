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
    $customer_id               = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $productType_id            = $_POST['productType_id'] ?? null;
    $productGroup_name         = $_POST['productGroup_name'] ?? null;
    $productGroup_description  = $_POST['productGroup_description'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
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
    // Ensure Product Type exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM productType WHERE id = :id'
    );
    $check->execute([':id' => $productType_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Product Type does not exist');
    }

    // ---------------------------------------------------------------------
    // Insert Product Group
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO productGroup (
            customer_id,
            productType_id,
            productGroup_name,
            productGroup_description
        ) VALUES (
            :customer_id,
            :productType_id,
            :productGroup_name,
            :productGroup_description
        )'
    );

    $stmt->execute([
        ':customer_id'               => $customer_id,
        ':productType_id'            => $productType_id,
        ':productGroup_name'         => $productGroup_name,
        ':productGroup_description'  => $productGroup_description
    ]);

    $pdo->commit();

    echo 'Product Group created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create product group: ' . $e->getMessage();
};


//Run: php create_productGroup.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 productType_id=1 productGroup_name=Test productGroup_description="Test test"