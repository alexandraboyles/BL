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

    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $product_id  = $_POST['product_id'] ?? null;   // business product_id
    $customer_id = $_POST['customer_id'] ?? null;  // UUID

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($product_id === null || trim((string)$product_id) === '') {
        throw new InvalidArgumentException('product_id is required');
    }

    if ($customer_id === null || trim((string)$customer_id) === '') {
        throw new InvalidArgumentException('customer_id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM customer WHERE id = :id'
    );
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure product exists and belongs to customer
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM Product
         WHERE product_id = :product_id
           AND customer_id = :customer_id'
    );

    $stmt->execute([
        ':product_id'  => $product_id,
        ':customer_id' => $customer_id
    ]);

    $productUuid = $stmt->fetchColumn();

    if ($productUuid === false) {
        throw new RuntimeException('Product does not exist for this customer');
    }

    // ---------------------------------------------------------------------
    // FK safety: ensure product is not used in consignments
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Consignment WHERE product_id = :product_uuid LIMIT 1'
    );
    $check->execute([':product_uuid' => $productUuid]);

    if ($check->fetchColumn()) {
        throw new RuntimeException('Cannot delete product: it is used in consignments');
    }

    // ---------------------------------------------------------------------
    // Delete product
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM Product WHERE id = :id'
    );

    $delete->execute([
        ':id' => $productUuid
    ]);

    $pdo->commit();

    echo 'Product deleted successfully. UUID: ' . $productUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete product: ' . $e->getMessage();
}

//Run: php delete_product.php product_id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187