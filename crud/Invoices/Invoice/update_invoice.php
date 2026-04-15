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
    $id                 = $_POST['id'] ?? null;           // UUID → Invoice.id
    $invoice_id         = $_POST['invoice_id'] ?? null;
    $customer_id        = $_POST['customer_id'] ?? null;
    $rateCard_id        = $_POST['rateCard_id'] ?? null;
    $manifest_id        = $_POST['manifest_id'] ?? null;
    $income             = $_POST['income'] ?? null;
    $expense            = $_POST['expense'] ?? null;
    $status             = $_POST['status'] ?? null;
    $paymentStatus      = $_POST['paymentStatus'] ?? null;
    $emailStatus        = $_POST['emailStatus'] ?? null;
    $internalReference  = $_POST['internalReference'] ?? null;
    $externalReference  = $_POST['externalReference'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id'                => $id,
        'invoice_id'        => $invoice_id,
        'customer_id'       => $customer_id,
        'rateCard_id'       => $rateCard_id,
        'manifest_id'       => $manifest_id,
        'income'            => $income,
        'expense'           => $expense,
        'status'            => $status,
        'paymentStatus'     => $paymentStatus,
        'emailStatus'       => $emailStatus,
        'internalReference' => $internalReference,
        'externalReference' => $externalReference,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Invoice exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM Invoice WHERE id = :id');
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Invoice does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Customer exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM Customer WHERE id = :id');
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Rate Card exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM rateCard WHERE id = :id');
    $check->execute([':id' => $rateCard_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Rate Card does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure Manifest exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM manifest WHERE id = :id');
    $check->execute([':id' => $manifest_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Manifest does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Invoice
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Invoice SET
            invoice_id        = :invoice_id,
            customer_id       = :customer_id,
            rateCard_id       = :rateCard_id,
            manifest_id       = :manifest_id,
            income            = :income,
            expense           = :expense,
            status            = :status,
            paymentStatus     = :paymentStatus,
            emailStatus       = :emailStatus,
            internalReference = :internalReference,
            externalReference = :externalReference
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'                => $id,
        ':invoice_id'        => $invoice_id,
        ':customer_id'       => $customer_id,
        ':rateCard_id'       => $rateCard_id,
        ':manifest_id'       => $manifest_id,
        ':income'            => $income,
        ':expense'           => $expense,
        ':status'            => $status,
        ':paymentStatus'     => $paymentStatus,
        ':emailStatus'       => $emailStatus,
        ':internalReference' => $internalReference,
        ':externalReference' => $externalReference,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('No changes were applied');
    }

    $pdo->commit();

    echo 'Invoice updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update invoice: ' . $e->getMessage();
}

//Run: php update_invoice.php id=201074f7-b538-477a-8b46-23e033178317 invoice_id=1004 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 rateCard_id=5 manifest_id=2 income=534.90 expense=0.00 status=Leeching paymentStatus="Awaiting Payment" emailStatus="Not sent" internalReference="W.E 11/04/26 (BrisLog:10556)" externalReference=INV-10668