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
    $id = $_POST['id'] ?? null; 

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id === null || trim((string)$id) === '') {
        throw new InvalidArgumentException('id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure FTP User exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT id FROM ftpUser WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    $ftpUserUuid = $check->fetchColumn();

    if ($ftpUserUuid === false) {
        throw new RuntimeException('FTP User does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete FTP User
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'DELETE FROM ftpUser WHERE id = :id'
    );

    $stmt->execute([
        ':id' => $ftpUserUuid
    ]);

    $pdo->commit();

    echo 'FTP User deleted successfully. UUID: ' . $ftpUserUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete ftp user: ' . $e->getMessage();
}

//Run: php delete_ftpUser.php id=6244d264-c87a-4be4-889e-392a92327e24