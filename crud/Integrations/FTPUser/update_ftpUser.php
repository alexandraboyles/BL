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
    $id  = $_POST['id']   ?? null; // UUID of FTP User row
    $ftpUser_id = $_POST['ftpUser_id'] ?? null;
    $username   = $_POST['username']   ?? null;
    $password   = $_POST['password']   ?? null;
    $subDirectory  = $_POST['subDirectory']  ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id === null || trim($id) === '') {
        throw new InvalidArgumentException('id (UUID) is required');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    foreach ([
        'id' => $id,
        'ftpUser_id' => $ftpUser_id,
        'username' => $username,
        'password' => $hashedPassword,
        'subDirectory'   => $subDirectory,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure FTP User exists
    // ---------------------------------------------------------------------
    $checkFTPUser = $pdo->prepare(
        'SELECT 1 FROM ftpUser WHERE id = :id'
    );
    $checkFTPUser->execute([':id' => $id]);

    if ($checkFTPUser->fetchColumn() === false) {
        throw new RuntimeException('FTP User does not exist');
    }

    // ---------------------------------------------------------------------
    // Update FTP User
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE ftpUser
         SET
            ftpUser_id = :ftpUser_id,
            username = :username,
            password = :password,
            subDirectory   = :subDirectory
         WHERE id = :id'
    );

    $stmt->execute([
        'id'   => $id,
        'ftpUser_id'   => $ftpUser_id,
        ':username' => $username,
        ':password' => $hashedPassword,
        ':subDirectory'   => $subDirectory,
    ]);

    $pdo->commit();

    echo 'FTP User updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update ftp user: ' . $e->getMessage();
}

//Run: php update_ftpUser.php id=63579635-1ac7-4051-8c9f-8f5d0ad8303c ftpUser_id=1001 username=lexiebb password=lexie123 subDirectory=/home/ftp_lexie
