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
    $surcharge_name  = $_POST['surcharge_name'] ?? null;   // surcharge name

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($surcharge_name === null || trim((string)$surcharge_name) === '') {
        throw new InvalidArgumentException('Surcharge name is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Surcharge name exists
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT surcharge_name, status
         FROM surcharge
         WHERE surcharge_name = :surcharge_name'
    );

    $stmt->execute([
        ':surcharge_name'  => $surcharge_name
    ]);

    $surcharge = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($surcharge === false) {
        throw new RuntimeException('Surcharge does not exist');
    }

    // ---------------------------------------------------------------------
    // Business rule: prevent deleting active surcharges
    // ---------------------------------------------------------------------
    if ($surcharge['status'] === 'Active') {
        throw new RuntimeException('Cannot delete an active surcharge');
    }

    // ---------------------------------------------------------------------
    // Delete Surcharge
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM surcharge WHERE surcharge_name = :surcharge_name'
    );

    $delete->execute([
        ':surcharge_name' => $surcharge_name
    ]);

    $pdo->commit();

    echo 'Surcharge deleted successfully. Surcharge Name: ' . $surcharge_name;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete surcharge: ' . $e->getMessage();
}

//Run: php delete_surcharge.php surcharge_name="Urgent Processing Surcharge"