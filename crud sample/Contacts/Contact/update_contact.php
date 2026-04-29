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
    $id           = $_POST['id'] ?? null;     // UUID → id
    $customerId   = $_POST['customer_id'] ?? null;    // UUID → Customer.id
    $contact_name = $_POST['contact_name'] ?? null;
    $email        = $_POST['email'] ?? null;
    $phone        = $_POST['phone'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id=== null || trim($id) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
    }

    foreach ([
        'id'           => $id,
        'customer_id'  => $customerId,
        'contact_name' => $contact_name,
        'email'        => $email,
        'phone'        => $phone,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Contact exists
    // ---------------------------------------------------------------------
    $checkContact = $pdo->prepare(
        'SELECT 1 FROM Contact WHERE id = :id'
    );
    $checkContact->execute([':id' => $id]);

    if ($checkContact->fetchColumn() === false) {
        throw new RuntimeException('Contact does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Customer exists (FK safety)
    // ---------------------------------------------------------------------
    $checkCustomer = $pdo->prepare(
        'SELECT 1 FROM Customer WHERE id = :id'
    );
    $checkCustomer->execute([':id' => $customerId]);

    if ($checkCustomer->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Contact
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Contact
         SET
            customer_id  = :customer_id,
            contact_name = :contact_name,
            email        = :email,
            phone        = :phone
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'          => $id,
        ':customer_id' => $customerId,
        ':contact_name'=> $contact_name,
        ':email'       => $email,
        ':phone'       => $phone,
    ]);

    $pdo->commit();

    echo 'Contact updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update contact: ' . $e->getMessage();
}

//Run: php update_contact.php id=ae9aaec5-1dd3-49b8-adc0-5578a6db8708 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 contact_name="Mark Dinglasa" email=mark.dinglasa@gmail.com phone=09245678901
