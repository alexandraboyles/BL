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
    // Ensure Adhoc Charge Setup exists
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM adhocChargeSetup
         WHERE id = :id'
    );

    $stmt->execute([':id' => $id,]);

    $adhocId = $stmt->fetchColumn();

    if ($adhocId === false) {
        throw new RuntimeException('Adhoc Charge Setup does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete Adhoc Charge Setup
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM adhocChargeSetup WHERE id = :id'
    );

    $delete->execute([
        ':id' => $adhocId,
    ]);

    $pdo->commit();

    echo 'Adhoc Charge Setup deleted successfully. ID: ' . $adhocId;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete adhoc charge setup: ' . $e->getMessage();
}

//Run: php delete_adhocChargeSetup.php id=1002
