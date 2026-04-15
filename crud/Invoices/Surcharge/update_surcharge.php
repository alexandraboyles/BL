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
    $feeCategory_id = $_POST['feeCategory_id'] ?? null; // UUID → feeCategory.id
    $surcharge_name = $_POST['surcharge_name'] ?? null;
    $conditions     = $_POST['conditions'] ?? null;
    $surcharge      = $_POST['surcharge'] ?? null;
    $status         = $_POST['status'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'feeCategory_id' => $feeCategory_id,
        'surcharge_name' => $surcharge_name,
        'conditions'     => $conditions,
        'surcharge'      => $surcharge,
        'status'         => $status,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Surcharge Name exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM surcharge WHERE surcharge_name = :surcharge_name');
    $check->execute([':surcharge_name' => $surcharge_name]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Surcharge name does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Surcharge
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE surcharge SET
            feeCategory_id    = :feeCategory_id,
            surcharge_name    = :surcharge_name,
            conditions        = :conditions,
            surcharge         = :surcharge,
            status            = :status
         WHERE surcharge_name = :surcharge_name'
    );

    $stmt->execute([
        ':feeCategory_id'  => $feeCategory_id,
        ':surcharge_name'  => $surcharge_name,
        ':conditions'      => $conditions,
        ':surcharge'       => $surcharge,
        ':status'          => $status,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('No changes were applied');
    }

    $pdo->commit();

    echo 'Surcharge updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update surcharge: ' . $e->getMessage();
}

//Run: php create_surcharge.php feeCategory_id=1 surcharge_name="Urgent Processing Surcharge" conditions="Applied when service is requested within 24 hours" surcharge=500 status=Inactive