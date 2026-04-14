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
    $ftpUserId = $_POST['ftpUser_id'] ?? null;
    $username   = $_POST['username']   ?? null;
    $password = $_POST['password']   ?? null;
    $subDirectory  = $_POST['subDirectory']     ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    if ($ftpUserId === null || $ftpUserId === '' || !ctype_digit((string)$ftpUserId)) {
        throw new InvalidArgumentException('ftpUser_id is required and must be an integer');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    foreach ([
        'username' => $username,
        'password' => $hashedPassword,
        'subDirectory'   => $subDirectory,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    $ftpUserId = (int) $ftpUserId;

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
    // Insert FTP User
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO ftpUser (
            id,
            ftpUser_id,
            username,
            password,
            subDirectory
        ) VALUES (
            :id,
            :ftpUser_id,
            :username,
            :password,
            :subDirectory
        )'
    );

    $stmt->execute([
        ':id'         => $uuid,
        ':ftpUser_id' => $ftpUserId,
        ':username'   => $username,
        ':password'   => $hashedPassword,
        ':subDirectory'  => $subDirectory,
    ]);

    $pdo->commit();

    echo 'FTP User created successfully. UUID: ' . $uuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create ftp user: ' . $e->getMessage();
};


//Run: php create_ftpUser.php ftpUser_id=1002 username=lexie password=lexie123 subDirectory=/home/ftp_lexie