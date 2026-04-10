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
    $product_id = $_POST['product_id'] ?? null;
    $customer_id = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $title     = $_POST['title'] ?? null;
    $description    = $_POST['description'] ?? null;
    $sku  = $_POST['sku'] ?? null;
    $unitOfMeasure       = $_POST['unitOfMeasure'] ?? null;
    $width = $_POST['width'] ?? null;
    $length = $_POST['length'] ?? null;
    $height = $_POST['height'] ?? null;
    $weight = $_POST['weight'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'product_id' => $product_id,
        'customer_id'        => $customer_id,
        'title'       => $title,
        'description'       => $description,
        'sku'       => $sku,
        'unitOfMeasure'       => $unitOfMeasure,
        'width'  => $width,
        'length'  => $length,
        'height'  => $height,
        'width'  => $width,
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
    // Insert Product
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO Product (
            id,
            product_id,
            customer_id,
            title,
            description,
            sku,
            unitOfMeasure,
            width,
            length,
            height,
            weight
        ) VALUES (
            :id,
            :product_id,
            :customer_id,
            :title,
            :description,
            :sku,
            :unitOfMeasure,
            :width,
            :length,
            :height,
            :weight
        )'
    );

    $stmt->execute([
        ':id'          => $uuid,
        ':product_id'          => $product_id,
        ':customer_id' => $customer_id,
        ':title'        => $title,
        ':description'       => $description,
        ':sku'       => $sku,
        ':unitOfMeasure'       => $unitOfMeasure,
        ':width'       => $width,
        ':length'       => $length,
        ':height'       => $height,
        ':weight'       => $weight,
    ]);

    $pdo->commit();

    echo 'Product created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create product: ' . $e->getMessage();
};


//Run: php create_product.php product_id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 title=Corrugated Shipping Box description=Heavy-duty corrugated cardboard box for shipping sku=BOX-CORR-18X14S unitOfMeasure=cm width=30.0 length=40.0 height=25.0 weight=2.5