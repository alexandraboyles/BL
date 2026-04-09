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

require __DIR__ . '/../../db_connect.php';

try {

    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $invoice_id  = $_POST['invoice_id'] ?? null;   // business invoice id
    $customer_id = $_POST['customer_id'] ?? null; // UUID

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($invoice_id === null || trim((string)$invoice_id) === '') {
        throw new InvalidArgumentException('invoice_id is required');
    }

    if ($customer_id === null || trim((string)$customer_id) === '') {
        throw new InvalidArgumentException('customer_id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM customer WHERE id = :id'
    );
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Ensure invoice exists and belongs to customer
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id, paymentStatus
         FROM Invoice
         WHERE invoice_id = :invoice_id
           AND customer_id = :customer_id'
    );

    $stmt->execute([
        ':invoice_id'  => $invoice_id,
        ':customer_id' => $customer_id
    ]);

    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($invoice === false) {
        throw new RuntimeException('Invoice does not exist for this customer');
    }

    // ---------------------------------------------------------------------
    // Business rule: prevent deleting paid invoices
    // ---------------------------------------------------------------------
    if (strtolower($invoice['paymentStatus']) === 'paid') {
        throw new RuntimeException('Cannot delete a paid invoice');
    }

    $invoiceUuid = $invoice['id'];

    // ---------------------------------------------------------------------
    // Delete invoice
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM Invoice WHERE id = :id'
    );

    $delete->execute([
        ':id' => $invoiceUuid
    ]);

    $pdo->commit();

    echo 'Invoice deleted successfully. UUID: ' . $invoiceUuid;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete invoice: ' . $e->getMessage();
}

//Run: php delete_invoice.php invoice_id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187