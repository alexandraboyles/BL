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
    $productType_name          = $_POST['productType_name'] ?? null;
    $product_code              = $_POST['product_code'] ?? null;
    $alias                     = $_POST['alias'] ?? null;
    $priority                  = $_POST['priority'] ?? null;
    $is_default                = $_POST['is_default'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
        'productType_name'   => $productType_name,
        'product_code'       => $product_code,
        'alias'              => $alias,
        'priority'           => $priority,
        'is_default'         => $is_default
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Insert Product Type
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO productType (
            productType_name,
            product_code,
            alias,
            priority,
            is_default
        ) VALUES (
            :productType_name,
            :product_code,
            :alias,
            :priority,
            :is_default
        )'
    );

    $stmt->execute([
        ':productType_name'  => $productType_name,
        ':product_code'      => $product_code,
        ':alias'             => $alias,
        ':priority'          => $priority,
        'is_default'         => $is_default
    ]);

    $pdo->commit();

    echo 'Product Type created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create product type: ' . $e->getMessage();
};


//Run: php create_productType.php productType_name="Test product" product_code=T alias=Test priority=4 is_default=1