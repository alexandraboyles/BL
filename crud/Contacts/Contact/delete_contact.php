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

require __DIR__ . '/../../db_connect.php';

try {

    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $customerId   = $_POST['customer_id'] ?? null;   // UUID
    $contact_name = $_POST['contact_name'] ?? null;
    $email        = $_POST['email'] ?? null;
    $phone        = $_POST['phone'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'customer_id'   => $customerId,
        'contact_name'  => $contact_name,
        'email'         => $email,
        'phone'         => $phone,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure customer exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Customer WHERE id = :id'
    );
    $check->execute([':id' => $customerId]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure contact exists and belongs to customer
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM Contact
         WHERE customer_id = :customer_id
           AND contact_name = :contact_name
           AND email = :email
           AND phone = :phone'
    );

    $stmt->execute([
        ':customer_id'  => $customerId,
        ':contact_name' => $contact_name,
        ':email'        => $email,
        ':phone'        => $phone,
    ]);

    $contactUuid = $stmt->fetchColumn();

    if ($contactUuid === false) {
        throw new RuntimeException('Contact does not exist for this customer');
    }

    // ---------------------------------------------------------------------
    // Delete contact
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM Contact WHERE id = :id'
    );

    $delete->execute([
        ':id' => $contactUuid
    ]);

    $pdo->commit();

    echo 'Contact deleted successfully. UUID: ' . $contactUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete contact: ' . $e->getMessage();
}

//Run: php delete_contact.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 contact_name="Alexandra Boyles" email=alex@gmail.com phone=09664503890