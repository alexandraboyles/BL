<?php
declare(strict_types=1);

// ------------------------------------------------------------
// Allow CLI arguments like key=value&key2=value2
// ------------------------------------------------------------
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
}

require __DIR__ . '/../../../db_connect.php';

try {
    // --------------------------------------------------------
    // Collect input (at least ONE filter is required)
    // --------------------------------------------------------
    $supplier_id = $_POST['supplier_id'] ?? null; // UUID → Supplier.id
    $invoice_id = $_POST['invoice_id'] ?? null; // UUID → Invoice.id
    $manifest_id = $_POST['manifest_id'] ?? null;

    if ($supplier_id === null && $invoice_id === null && $manifest_id === null) {
        throw new InvalidArgumentException(
            'At least one filter is required: supplier_id or invoice_id or manifest_id'
        );
    }

    // --------------------------------------------------------
    // Build dynamic WHERE clause
    // --------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($supplier_id !== null) {
        $conditions[] = 'astring.supplier_id = :supplier_id';
        $params[':supplier_id'] = $supplier_id;
    }

    if ($invoice_id !== null) {
        $conditions[] = 'astring.invoice_id = :invoice_id';
        $params[':invoice_id'] = $invoice_id;
    }

    if ($manifest_id !== null) {
        $conditions[] = 'astring.manifest_id = :manifest_id';
        $params[':manifest_id'] = $manifest_id;
    }

    $whereSql = implode(' AND ', $conditions);

    // --------------------------------------------------------
    // Fetch Bills
    // --------------------------------------------------------
    $stmt = $pdo->prepare(
        "SELECT
            astring.id,
            astring.supplier_id,
            astring.invoice_id,
            astring.manifest_id
         FROM bill astring
         WHERE $whereSql"
    );

    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --------------------------------------------------------
    // Output JSON
    // --------------------------------------------------------
    echo json_encode([
        'status' => 'success',
        'count'  => count($rows),
        'data'   => $rows
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    http_response_code(400);

    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
}

//Run: 
//Read bill by supplier
    //php read_bill.php supplier_id=1
//List all bills for an invoice
    //php read_bill.php invoice_id=c8e064b2-fcad-4906-a1d4-4b1f9458bdc5
//List all bills for a manifest
    //php read_bill.php manifest_id=2
//Combine filters
    //php read_bill.php supplier_id=1 invoice_id=c8e064b2-fcad-4906-a1d4-4b1f9458bdc5 manifest_id=2