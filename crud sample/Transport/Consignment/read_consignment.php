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

try {

    // -----------------------------------------------------------------
    // Collect optional filters
    // -----------------------------------------------------------------
    $id              = $_REQUEST['id'] ?? null;                // UUID
    $consignment_id  = $_REQUEST['consignment_id'] ?? null;    // Human ID
    $saleOrder_id    = $_REQUEST['saleOrder_id'] ?? null;
    $address_id      = $_REQUEST['address_id'] ?? null;
    $product_id      = $_REQUEST['product_id'] ?? null;
    $deliveryRun_id  = $_REQUEST['deliveryRun_id'] ?? null;
    $driver_id       = $_REQUEST['driver_id'] ?? null;
    $runsheet_id     = $_REQUEST['runsheet_id'] ?? null;
    $service         = $_REQUEST['service'] ?? null;
    $is_residential  = $_REQUEST['is_residential'] ?? null;

    // -----------------------------------------------------------------
    // Require at least one filter
    // -----------------------------------------------------------------
    if (
        !$id && !$consignment_id && !$saleOrder_id &&
        !$deliveryRun_id && !$driver_id && !$runsheet_id
    ) {
        throw new InvalidArgumentException(
            'At least one identifier is required (id, consignment_id, saleOrder_id, deliveryRun_id, driver_id, runsheet_id)'
        );
    }

    // -----------------------------------------------------------------
    // Build WHERE clause dynamically
    // -----------------------------------------------------------------
    $conditions = [];
    $params     = [];

    if ($id) {
        $conditions[] = 'c.id = :id';
        $params[':id'] = $id;
    }

    if ($consignment_id) {
        $conditions[] = 'c.consignment_id = :consignment_id';
        $params[':consignment_id'] = $consignment_id;
    }

    if ($saleOrder_id) {
        $conditions[] = 'c.saleOrder_id = :saleOrder_id';
        $params[':saleOrder_id'] = $saleOrder_id;
    }

    if ($address_id) {
        $conditions[] = 'c.address_id = :address_id';
        $params[':address_id'] = $address_id;
    }

    if ($product_id) {
        $conditions[] = 'c.product_id = :product_id';
        $params[':product_id'] = $product_id;
    }

    if ($deliveryRun_id) {
        $conditions[] = 'c.deliveryRun_id = :deliveryRun_id';
        $params[':deliveryRun_id'] = $deliveryRun_id;
    }

    if ($driver_id) {
        $conditions[] = 'c.driver_id = :driver_id';
        $params[':driver_id'] = $driver_id;
    }

    if ($runsheet_id) {
        $conditions[] = 'c.runsheet_id = :runsheet_id';
        $params[':runsheet_id'] = $runsheet_id;
    }

    if ($service) {
        $conditions[] = 'c.service = :service';
        $params[':service'] = $service;
    }

    if ($is_residential !== null) {
        $conditions[] = 'c.is_residential = :is_residential';
        $params[':is_residential'] = $is_residential;
    }

    $whereSql = implode(' AND ', $conditions);

    // -----------------------------------------------------------------
    // Query consignments with joins
    // -----------------------------------------------------------------
    $sql = "
        SELECT
            c.id,
            c.consignment_id,
            c.service,
            c.reference,
            c.is_residential,
            c.quantity,
            c.cubic,
            c.weight,
            c.pallets,
            c.spaces,

            so.id                AS saleOrder_id,
            so.orderReference    AS saleOrder_number,

            a.id                 AS address_id,
            a.street_1,
            a.suburb,
            a.state,
            a.postcode,

            p.id                 AS product_id,
            p.sku,

            dr.id                AS deliveryRun_id,
            dr.deliveryRun_name,

            d.id                 AS driver_id,
            d.driver_name,

            r.id                 AS runsheet_id

        FROM Consignment c
        JOIN saleOrder   so ON so.id = c.saleOrder_id
        JOIN address     a  ON a.id  = c.address_id
        JOIN product     p  ON p.id  = c.product_id
        JOIN deliveryRun dr ON dr.id = c.deliveryRun_id
        JOIN driver      d  ON d.id  = c.driver_id
        JOIN runsheet    r  ON r.id  = c.runsheet_id
        WHERE $whereSql
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $consignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // -----------------------------------------------------------------
    // Output
    // -----------------------------------------------------------------
    echo json_encode([
        'success' => true,
        'count'   => count($consignments),
        'data'    => $consignments
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

//Run:
//Read single consignment by id
    //php read_consignment.php consignment_id=1001
//List all consignments for a driver
    //php read_consignment.php driver_id=2bc93718-971b-487d-b1dd-8fb4f0a0b8ba
//List all consignments for a delivery run
    //php read_consignment.php deliveryRun_id=222e8400-e29b-41d4-a716-222222222222 service="Standard Delivery"