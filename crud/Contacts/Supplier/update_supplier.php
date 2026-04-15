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
    $supplier_id          = $_POST['supplier_id'] ?? null; // supplier.id (PK)
    $rateCard_id          = $_POST['rateCard_id'] ?? null; // rateCard.id (FK)
    $companyName          = $_POST['companyName'] ?? null;
    $email                = $_POST['email'] ?? null;
    $telNo                = $_POST['telNo'] ?? null;
    $accountingConnector  = $_POST['accountingConnector'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($supplier_id=== null || trim($supplier_id) === '') {
        throw new InvalidArgumentException('id is required');
    }

    foreach ([
        'supplier_id'          => $supplier_id,
        'rateCard_id'          => $rateCard_id,
        'companyName'          => $companyName,
        'email'                => $email,
        'telNo'                => $telNo,
        'accountingConnector'  => $accountingConnector,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Supplier exists
    // ---------------------------------------------------------------------
    $checkSupplier = $pdo->prepare(
        'SELECT 1 FROM supplier WHERE id = :id'
    );
    $checkSupplier->execute([':id' => $supplier_id]);

    if ($checkSupplier->fetchColumn() === false) {
        throw new RuntimeException('Supplier does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Rate Card exists (FK safety)
    // ---------------------------------------------------------------------
    $checkRateCard = $pdo->prepare(
        'SELECT 1 FROM rateCard WHERE id = :id'
    );
    $checkRateCard->execute([':id' => $rateCard_id]);

    if ($checkRateCard->fetchColumn() === false) {
        throw new RuntimeException('Rate Card does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Supplier
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE supplier
         SET
             rateCard_id         = :rateCard_id,
             companyName         = :companyName,
             email               = :email,
             telNo               = :telNo,
             accountingConnector = :accountingConnector
         WHERE id = :supplier_id'
    );

    $stmt->execute([
        ':supplier_id'         => $supplier_id,
        ':rateCard_id'         => $rateCard_id,
        ':companyName'         => $companyName,
        ':email'               => $email,
        ':telNo'               => $telNo,
        ':accountingConnector' => $accountingConnector,
    ]);

    $pdo->commit();

    echo 'Supplier updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update supplier: ' . $e->getMessage();
}

//Run: php update_supplier.php supplier_id=1 rateCard_id=5 companyName="TRO Updated" email=tro_updated@gmail.com telNo=0234567890 accountingConnector=Test
