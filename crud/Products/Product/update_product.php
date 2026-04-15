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
    $id             = $_POST['id'] ?? null;          // UUID → Product.id
    $product_id     = $_POST['product_id'] ?? null;
    $customer_id    = $_POST['customer_id'] ?? null;
    $title          = $_POST['title'] ?? null;
    $description    = $_POST['description'] ?? null;
    $sku            = $_POST['sku'] ?? null;
    $unitOfMeasure  = $_POST['unitOfMeasure'] ?? null;
    $width          = $_POST['width'] ?? null;
    $length         = $_POST['length'] ?? null;
    $height         = $_POST['height'] ?? null;
    $weight         = $_POST['weight'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id'             => $id,
        'product_id'     => $product_id,
        'customer_id'    => $customer_id,
        'title'          => $title,
        'description'    => $description,
        'sku'            => $sku,
        'unitOfMeasure'  => $unitOfMeasure,
        'width'          => $width,
        'length'         => $length,
        'height'         => $height,
        'weight'         => $weight,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Product exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM Product WHERE id = :id');
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Product does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM Customer WHERE id = :id');
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Product
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Product SET
            product_id    = :product_id,
            customer_id   = :customer_id,
            title         = :title,
            description   = :description,
            sku           = :sku,
            unitOfMeasure = :unitOfMeasure,
            width         = :width,
            length        = :length,
            height        = :height,
            weight        = :weight
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'             => $id,
        ':product_id'     => $product_id,
        ':customer_id'    => $customer_id,
        ':title'          => $title,
        ':description'    => $description,
        ':sku'            => $sku,
        ':unitOfMeasure'  => $unitOfMeasure,
        ':width'          => $width,
        ':length'         => $length,
        ':height'         => $height,
        ':weight'         => $weight,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('No changes were applied');
    }

    $pdo->commit();

    echo 'Product updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update product: ' . $e->getMessage();
}

//Run: php update_product.php id=bf1965da-2afe-4644-80d6-ebd1d8122f07 product_id=1002 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 title="Corrugated Shipping Box" description="Heavy-duty corrugated cardboard box for shipping" sku=BOX-CORR-16X12S unitOfMeasure=cm width=30.0 length=40.0 height=25.0 weight=2.5
