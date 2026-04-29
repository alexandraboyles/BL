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
         FROM Contact
         WHERE id = :id'
    );

    $stmt->execute([':id'  => $id,]);

    $contactUuid = $stmt->fetchColumn();

    if ($contactUuid === false) {
        throw new RuntimeException('Contact does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete Contact
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

//Run: php delete_contact.php id=ead395a6-96d4-47f2-a87c-71695b4f09c4