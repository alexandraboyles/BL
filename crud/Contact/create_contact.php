<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
};

require __DIR__ . '/../../db_connect.php';

try {
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $customerId = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $contact_name       = $_POST['contact_name'] ?? null;
    $email      = $_POST['email'] ?? null;
    $phone      = $_POST['phone'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'customer_id' => $customerId,
        'contact_name'        => $contact_name,
        'email'       => $email,
        'phone'       => $phone,
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
    $check->execute([':id' => $customerId]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Generate Contact UUID
    // ---------------------------------------------------------------------
    $uuid = sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        random_int(0, 0xffff),
        random_int(0, 0xffff),
        random_int(0, 0xffff),
        random_int(0, 0x0fff) | 0x4000,
        random_int(0, 0x3fff) | 0x8000,
        random_int(0, 0xffff),
        random_int(0, 0xffff),
        random_int(0, 0xffff)
    );

    // ---------------------------------------------------------------------
    // Insert Contact
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO Contact (
            id,
            customer_id,
            contact_name,
            email,
            phone
        ) VALUES (
            :id,
            :customer_id,
            :contact_name,
            :email,
            :phone
        )'
    );

    $stmt->execute([
        ':id'          => $uuid,
        ':customer_id' => $customerId,
        ':contact_name'        => $contact_name,
        ':email'       => $email,
        ':phone'       => $phone,
    ]);

    $pdo->commit();

    echo 'Contact created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create contact: ' . $e->getMessage();
};


//Run: php create_contact.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 contact_name="Alexandra Boyles" email=alex@gmail.com phone=09664503890