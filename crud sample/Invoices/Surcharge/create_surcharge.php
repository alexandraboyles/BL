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
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Fee Category exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM feeCategory WHERE id = :id'
    );
    $check->execute([':id' => $feeCategory_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Fee Category does not exist');
    }

    // ---------------------------------------------------------------------
    // Insert Surcharge
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO surcharge (
            feeCategory_id,
            surcharge_name,
            conditions,
            surcharge,
            status
        ) VALUES (
            :feeCategory_id,
            :surcharge_name,
            :conditions,
            :surcharge,
            :status
        )'
    );

    $stmt->execute([
        ':feeCategory_id'  => $feeCategory_id,
        ':surcharge_name'  => $surcharge_name,
        ':conditions'      => $conditions,
        ':surcharge'       => $surcharge,
        ':status'          => $status,
    ]);

    $pdo->commit();

    echo 'Surcharge created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create surcharge: ' . $e->getMessage();
};


//Run: php create_surcharge.php feeCategory_id=1 surcharge_name="Late Payment Surcharge" conditions="Applied when payment is made more than 30 days after due date" surcharge=250 status=Active