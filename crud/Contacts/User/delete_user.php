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
        throw new InvalidArgumentException("id is required");
    }
    
    // ---------------------------------------------------------------------
    // Ensure Contact exists
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM user
         WHERE id = :id'
    );

    $stmt->execute([':id'  => $id,]);

    $userUuid = $stmt->fetchColumn();

    if ($userUuid === false) {
        throw new RuntimeException('User does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete User
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM user WHERE id = :id'
    );

    $delete->execute([
        ':id' => $userUuid
    ]);

    $pdo->commit();

    echo 'User deleted successfully. UUID: ' . $userUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete user: ' . $e->getMessage();
}

//Run: php delete_user.php id=e3cac328-0443-4290-8e05-3dedcf73dcb2