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
    $supplier_id = $_POST['supplier_id'] ?? null; // UUID → Supplier.id
    $invoice_id = $_POST['invoice_id'] ?? null; // UUID → Invoice.id
    $manifest_id = $_POST['manifest_id'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
        'supplier_id' => $supplier_id,
        'invoice_id' => $invoice_id,
        'manifest_id' => $manifest_id,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Supplier exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM supplier WHERE id = :id'
    );
    $check->execute([':id' => $supplier_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Supplier does not exist');
    }

    
    // ---------------------------------------------------------------------
    // Ensure Invoice exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Invoice WHERE id = :id'
    );
    $check->execute([':id' => $invoice_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Invoice does not exist');
    }
        
    // ---------------------------------------------------------------------
    // Ensure Manifest exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Manifest WHERE id = :id'
    );
    $check->execute([':id' => $manifest_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Manifest does not exist');
    }

    // ---------------------------------------------------------------------
    // Insert Bill
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO bill (
            supplier_id,
            invoice_id,
            manifest_id
        ) VALUES (
            :supplier_id,
            :invoice_id,
            :manifest_id
        )'
    );

    $stmt->execute([
        ':supplier_id'  => $supplier_id,
        ':invoice_id' => $invoice_id,
        ':manifest_id' => $manifest_id,
    ]);

    $pdo->commit();

    echo 'Bill created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create bill: ' . $e->getMessage();
};


//Run: php create_bill.php supplier_id=1 invoice_id=c8e064b2-fcad-4906-a1d4-4b1f9458bdc5 manifest_id=2