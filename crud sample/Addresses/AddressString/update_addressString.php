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
    $id          = $_POST['id'] ?? null;          // addressString.id
    $address_id  = $_POST['address_id'] ?? null; // Address.id
    $customer_id = $_POST['customer_id'] ?? null; // Customer.id
    $text        = $_POST['text'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id'          => $id,
        'address_id'  => $address_id,
        'customer_id' => $customer_id,
        'text' => $text,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Address String exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM addressString WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Address string does not exist');
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
    // Update Address String
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE addressString
         SET
            address_id  = :address_id,
            customer_id = :customer_id,
            text        = :text
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'          => $id,
        ':address_id'  => $address_id,
        ':customer_id' => $customer_id,
        ':text'        => $text,
    ]);

    $pdo->commit();

    echo 'Address String updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update address string: ' . $e->getMessage();
}

//Run: php update_addressString.php id=1001 address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 text="Updated address text"