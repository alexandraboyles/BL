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
    $customerId         = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $fullName           = $_POST['fullName'] ?? null;
    $email              = $_POST['email'] ?? null;
    $roles              = $_POST['roles'] ?? null;
    $warehouses         = $_POST['warehouses'] ?? null;
    $mfa                = $_POST['mfa'] ?? null;
    $is_email_verified  = $_POST['is_email_verified'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
        'customer_id'       => $customerId,
        'fullName'          => $fullName,
        'email'             => $email,
        'roles'             => $roles,
        'warehouses'        => $warehouses,
        'mfa'               => $mfa,
        'is_email_verified' => $is_email_verified,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
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
    // Insert User
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO user (
            id,
            customer_id,
            fullName,
            email,
            roles,
            warehouses,
            mfa,
            is_email_verified
        ) VALUES (
            :id,
            :customer_id,
            :fullName,
            :email,
            :roles,
            :warehouses,
            :mfa,
            :is_email_verified
        )'
    );

    $stmt->execute([
        ':id'                => $uuid,
        ':customer_id'       => $customerId,
        ':fullName'          => $fullName,
        ':email'             => $email,
        ':roles'             => $roles,
        ':warehouses'        => $warehouses,
        ':mfa'               => $mfa,
        ':is_email_verified' => $is_email_verified,
    ]);

    $pdo->commit();

    echo 'User created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create user: ' . $e->getMessage();
};


//Run: php create_user.php customer_id=ddf497c2-480c-4fc8-bbcd-dd5a5c5478c1 fullName="Mark Dinglasa" email=mark.dinglasa@gmail.com roles=Test warehouses=test mfa=test001 is_email_verified=1