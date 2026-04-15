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

    // -----------------------------------------------------------------
    // Collect input
    // -----------------------------------------------------------------
    $id = $_POST['id'] ?? null; 

    // -----------------------------------------------------------------
    // Validate input
    // -----------------------------------------------------------------
    if ($id === null || trim((string)$id) === '') {
        throw new InvalidArgumentException("id is required");
    }

    // -----------------------------------------------------------------
    // Ensure Location exists
    // -----------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM location
         WHERE id = :id'
    );

    $stmt->execute([':id' => $id]);

    $locationUuid = $stmt->fetchColumn();

    if ($locationUuid === false) {
        throw new RuntimeException('Location does not exist');
    }

    // // ---------------------------------------------------------------------
    // // FK safety checks (location used elsewhere?)
    // // ---------------------------------------------------------------------

    // // Address Default Instruction
    // $check = $pdo->prepare(
    //     'SELECT 1 FROM addressDefaultInstruction WHERE customer_id = :customer_uuid LIMIT 1'
    // );
    // $check->execute([':customer_uuid' => $customerUuid]);

    // if ($check->fetchColumn()) {
    //     throw new RuntimeException('Cannot delete customer: it is in use by address default instruction');
    // }


    // -----------------------------------------------------------------
    // Delete Location
    // -----------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM location WHERE id = :id'
    );

    $delete->execute([
        ':id' => $locationUuid,
    ]);

    $pdo->commit();

    echo 'Location deleted successfully. UUID: ' . $locationUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete location: ' . $e->getMessage();
}

//Run: php delete_location.php id=d9e59d7b-98d4-4eb0-bcf9-45bb85ecd6da