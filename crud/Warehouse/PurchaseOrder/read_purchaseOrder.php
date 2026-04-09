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

require __DIR__ . '/../../db_connect.php';

header('Content-Type: application/json');

try {

    // -----------------------------------------------------------------
    // Collect optional filters
    // -----------------------------------------------------------------
    $id                = $_REQUEST['id'] ?? null;                  // UUID
    $purchase_order_id = $_REQUEST['purchase_order_id'] ?? null;   // Human ID
    $customer_id       = $_REQUEST['customer_id'] ?? null;
    $order_reference   = $_REQUEST['order_reference'] ?? null;
    $cust_reference    = $_REQUEST['cust_reference'] ?? null;
    $status            = $_REQUEST['status'] ?? null;

    // -----------------------------------------------------------------
    // Require at least one identifier
    // -----------------------------------------------------------------
    if (
        !$id && !$purchase_order_id && !$customer_id &&
        !$order_reference && !$cust_reference
    ) {
        throw new InvalidArgumentException(
            'At least one identifier is required (id, purchase_order_id, customer_id, order_reference, cust_reference)'
        );
    }

    // -----------------------------------------------------------------
    // Build WHERE clause dynamically
    // -----------------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($id) {
        $conditions[] = 'po.id = :id';
        $params[':id'] = $id;
    }

    if ($purchase_order_id) {
        $conditions[] = 'po.purchase_order_id = :purchase_order_id';
        $params[':purchase_order_id'] = $purchase_order_id;
    }

    if ($customer_id) {
        $conditions[] = 'po.customer_id = :customer_id';
        $params[':customer_id'] = $customer_id;
    }

    if ($order_reference) {
        $conditions[] = 'po.order_reference = :order_reference';
        $params[':order_reference'] = $order_reference;
    }

    if ($cust_reference) {
        $conditions[] = 'po.cust_reference = :cust_reference';
        $params[':cust_reference'] = $cust_reference;
    }

    if ($status) {
        $conditions[] = 'po.status = :status';
        $params[':status'] = $status;
    }

    $whereSql = implode(' AND ', $conditions);

    // -----------------------------------------------------------------
    // Query purchase orders (join customer for context)
    // -----------------------------------------------------------------
    $sql = "
        SELECT
            po.id,
            po.purchase_order_id,
            po.order_reference,
            po.cust_reference,
            po.ship_name,
            po.ship_address,
            po.status,

            c.id   AS customer_id,
            c.customer_name

        FROM purchaseOrder po
        JOIN customer c ON c.id = po.customer_id
        WHERE $whereSql
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $purchaseOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // -----------------------------------------------------------------
    // Output
    // -----------------------------------------------------------------
    echo json_encode([
        'success' => true,
        'count'   => count($purchaseOrders),
        'data'    => $purchaseOrders
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

//Run:
//Read single purchase order by id
//php read_purchaseOrder.php purchase_order_id=1001
//List all purchase orders for a customer
//php read_purchaseOrder.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 status=pending
//Read single purchase order by order reference
//php read_purchaseOrder.php order_reference=WEB-ORDER-77821