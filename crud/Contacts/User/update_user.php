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
    $id    = $_POST['id'] ?? null;     // UUID → id
    $customerId   = $_POST['customer_id'] ?? null;    // UUID → Customer.id
    $fullName    = $_POST['fullName'] ?? null;
    $email  = $_POST['email'] ?? null;
    $roles  = $_POST['roles'] ?? null;
    $warehouses  = $_POST['warehouses'] ?? null;
    $mfa  = $_POST['mfa'] ?? null;
    $is_email_verified  = $_POST['is_email_verified'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id=== null || trim($id) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
    }

    foreach ([
        'id'   => $id,
        'customer_id'  => $customerId,
        'fullName' => $fullName,
        'email'       => $email,
        'roles'   => $roles,
        'warehouses' => $warehouses,
        'mfa' => $mfa,
        'is_email_verified' => $is_email_verified,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure User exists
    // ---------------------------------------------------------------------
    $checkContact = $pdo->prepare(
        'SELECT 1 FROM user WHERE id = :id'
    );
    $checkContact->execute([':id' => $id]);

    if ($checkContact->fetchColumn() === false) {
        throw new RuntimeException('User does not exist');
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
    // Update User
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE user
         SET
            customer_id  = :customer_id,
            fullName = :fullName,
            email        = :email,
            roles        = :roles,
            warehouses = :warehouses,
            mfa    = :mfa,
            is_email_verified = :is_email_verified
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'  => $id,
        ':customer_id' => $customerId,
        ':fullName' => $fullName,
        ':email'    => $email,
        ':roles'    => $roles,
        ':warehouses' => $warehouses,
        ':mfa'    => $mfa,
        ':is_email_verified' => $is_email_verified,
    ]);

    $pdo->commit();

    echo 'User updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update user: ' . $e->getMessage();
}

//Run: php update_user.php id=2dc7171f-a789-4539-b260-15acdcd3dfab customer_id=ddf497c2-480c-4fc8-bbcd-dd5a5c5478c1 fullName="Mark Dinglasa Manos" email=mark.dinglasa@gmail.com roles=Test_updated warehouses=test mfa=test001 is_email_verified=1
