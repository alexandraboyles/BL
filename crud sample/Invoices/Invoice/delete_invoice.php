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
    $invoice_id  = $_POST['invoice_id'] ?? null;   // business invoice id

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($invoice_id === null || trim((string)$invoice_id) === '') {
        throw new InvalidArgumentException('invoice_id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Invoice exists
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id, paymentStatus
         FROM Invoice
         WHERE invoice_id = :invoice_id'
    );

    $stmt->execute([
        ':invoice_id'  => $invoice_id
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
    // Delete Invoice
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

//Run: php delete_invoice.php invoice_id=1004