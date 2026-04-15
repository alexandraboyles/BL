<?php
declare(strict_types=1);

// ---------------------------------------------------------------------
// Allow CLI arguments like key=value&key2=value2
// ---------------------------------------------------------------------
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_REQUEST = array_merge($_REQUEST, $parsed);
    }
}

require __DIR__ . '/../../../db_connect.php';

header('Content-Type: application/json');

try {

    // -----------------------------------------------------------------
    // Collect input (all optional, but at least one is required)
    // -----------------------------------------------------------------
    $id            = $_REQUEST['id'] ?? null;          // UUID
    $invoice_id    = $_REQUEST['invoice_id'] ?? null;  // Human invoice id
    $customer_id   = $_REQUEST['customer_id'] ?? null;
    $status        = $_REQUEST['status'] ?? null;
    $paymentStatus = $_REQUEST['paymentStatus'] ?? null;

    // -----------------------------------------------------------------
    // At least one identifier must be provided
    // -----------------------------------------------------------------
    if (!$id && !$invoice_id && !$customer_id) {
        throw new InvalidArgumentException(
            'At least one of id, invoice_id, or customer_id is required'
        );
    }

    // -----------------------------------------------------------------
    // Build dynamic WHERE clause
    // -----------------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($id) {
        $conditions[] = 'i.id = :id';
        $params[':id'] = $id;
    }

    if ($invoice_id) {
        $conditions[] = 'i.invoice_id = :invoice_id';
        $params[':invoice_id'] = $invoice_id;
    }

    if ($customer_id) {
        $conditions[] = 'i.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    if ($status) {
        $conditions[] = 'i.status = :status';
        $params[':status'] = $status;
    }

    if ($paymentStatus) {
        $conditions[] = 'i.paymentStatus = :paymentStatus';
        $params[':paymentStatus'] = $paymentStatus;
    }

    $whereSql = implode(' AND ', $conditions);

    // -----------------------------------------------------------------
    // Query invoices (joins included for useful reads)
    // -----------------------------------------------------------------
    $sql = "
        SELECT
            i.id,
            i.invoice_id,
            i.customer_id,
            c.customer_name,
            i.rateCard_id,
            i.manifest_id,
            i.income,
            i.expense,
            (i.income - i.expense) AS profit,
            i.status,
            i.paymentStatus,
            i.emailStatus,
            i.internalReference,
            i.externalReference
        FROM Invoice i
        JOIN customer  c  ON c.id  = i.customer_id
        JOIN manifest  m  ON m.id  = i.manifest_id
        WHERE $whereSql
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$invoices) {
        echo json_encode([
            'success' => true,
            'count'   => 0,
            'data'    => [],
            'message' => 'No invoices found'
        ]);
        exit;
    }

    // -----------------------------------------------------------------
    // Output
    // -----------------------------------------------------------------
    echo json_encode([
        'success' => true,
        'count'   => count($invoices),
        'data'    => $invoices
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

//Run:
//Read single invoice by id
    //php read_invoice.php invoice_id=1004
//List all invoices for a customer 
    //php read_invoice.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 paymentStatus=Awaiting