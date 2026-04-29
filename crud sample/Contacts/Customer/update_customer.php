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
    $id               = $_POST['id'] ?? null; // UUID of customer to update
    $customer_name    = $_POST['customer_name'] ?? null;
    $contact_phone    = $_POST['contact_phone'] ?? null;
    $contact_email    = $_POST['contact_email'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id=== null || trim($id) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
    }

    foreach ([
        'id'              => $id,
        'customer_name'   => $customer_name,
        'contact_phone'   => $contact_phone,
        'contact_email'   => $contact_email,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }
    
    // ---------------------------------------------------------------------
    // Ensure Customer exists
    // ---------------------------------------------------------------------
    $checkCustomer = $pdo->prepare(
        'SELECT 1 FROM Customer WHERE id = :id'
    );
    $checkCustomer->execute([':id' => $id]);

    if ($checkCustomer->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Customer
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Customer
         SET
            customer_name  = :customer_name,
            contact_phone  = :contact_phone,
            contact_email  = :contact_email
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'             => $id,
        ':customer_name'  => $customer_name,
        ':contact_phone'  => $contact_phone,
        ':contact_email'  => $contact_email,
    ]);

    $pdo->commit();

    echo 'Customer updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update customer: ' . $e->getMessage();
}

//Run: php update_customer.php id=ddf497c2-480c-4fc8-bbcd-dd5a5c5478c1 customer_name="Alexandra Boyles" contact_phone=09664503890 contact_email=alex_updated@gmail.com