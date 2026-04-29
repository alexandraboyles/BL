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
    $rateCard_id          = $_POST['rateCard_id'] ?? null; // RateCard.id
    $companyName          = $_POST['companyName'] ?? null;
    $email                = $_POST['email'] ?? null;
    $telNo                = $_POST['telNo'] ?? null;
    $accountingConnector  = $_POST['accountingConnector'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
        'rateCard_id'         => $rateCard_id,
        'companyName'         => $companyName,
        'email'               => $email,
        'telNo'               => $telNo,
        'accountingConnector' => $accountingConnector,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Rate Card exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM rateCard WHERE id = :id'
    );
    $check->execute([':id' => $rateCard_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Rate Card does not exist');
    }

    // ---------------------------------------------------------------------
    // Insert Supplier
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO supplier (
            rateCard_id,
            companyName,
            email,
            telNo,
            accountingConnector
        ) VALUES (
            :rateCard_id,
            :companyName,
            :email,
            :telNo,
            :accountingConnector
        )'
    );

    $stmt->execute([
        ':rateCard_id'         => $rateCard_id,
        ':companyName'         => $companyName,
        ':email'               => $email,
        ':telNo'               => $telNo,
        ':accountingConnector' => $accountingConnector,
    ]);

    $pdo->commit();

    echo 'Supplier created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create supplier: ' . $e->getMessage();
};


//Run: php create_supplier.php rateCard_id=5 companyName=TRO email=tro@gmail.com telNo=0234567890 accountingConnector=Test