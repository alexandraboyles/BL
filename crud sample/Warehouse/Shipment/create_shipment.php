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
    // -------------------------------------------------------------------------
    // Collect input
    // -------------------------------------------------------------------------
    $event_datetime     = $_POST['event_datetime'] ?? null;
    $client_name        = $_POST['client_name'] ?? null;
    $order_id           = $_POST['order_id'] ?? null;
    $order_reference    = $_POST['order_reference'] ?? null;
    $customer_name      = $_POST['customer_name'] ?? null;
    $freight_company    = $_POST['freight_company'] ?? null;
    $tracking_number    = $_POST['tracking_number'] ?? null;
    $freight_cost       = $_POST['freight_cost'] ?? null;
    $additional_cost    = $_POST['additional_cost'] ?? null;
    $consignment_charge = $_POST['consignment_charge'] ?? null;
    $complete           = $_POST['complete'] ?? 0;
    $order_url          = $_POST['order_url'] ?? null;
    $source             = $_POST['source'] ?? 'webhook';
    $external_id        = $_POST['external_id'] ?? null;
    $payload_hash       = $_POST['payload_hash'] ?? null;
    $payload_json       = $_POST['payload_json'] ?? null;

    // -------------------------------------------------------------------------
    // Validate input
    // -------------------------------------------------------------------------
    $errors = [];

    if (empty($event_datetime)) {
        $errors[] = 'event_datetime is required';
    }

    if (empty($client_name)) {
        $errors[] = 'client_name is required';
    }

    if (empty($order_id)) {
        $errors[] = 'order_id is required';
    } elseif (!is_numeric($order_id) || $order_id <= 0) {
        $errors[] = 'order_id must be a positive integer';
    }

    if (empty($customer_name)) {
        $errors[] = 'customer_name is required';
    }

    if (!empty($freight_cost) && !is_numeric($freight_cost)) {
        $errors[] = 'freight_cost must be numeric';
    }

    if (!empty($additional_cost) && !is_numeric($additional_cost)) {
        $errors[] = 'additional_cost must be numeric';
    }

    if (!empty($consignment_charge) && !is_numeric($consignment_charge)) {
        $errors[] = 'consignment_charge must be numeric';
    }

    if ($complete !== null && !in_array((int)$complete, [0, 1])) {
        $errors[] = 'complete must be 0 or 1';
    }

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // -------------------------------------------------------------------------
    // Convert payload_json if string
    // -------------------------------------------------------------------------
    if (is_string($payload_json)) {
        $payload_json = json_validate($payload_json) ? $payload_json : null;
    }

    // -------------------------------------------------------------------------
    // Insert shipment
    // -------------------------------------------------------------------------
    $sql = "INSERT INTO shipments (
                event_datetime,
                client_name,
                order_id,
                order_reference,
                customer_name,
                freight_company,
                tracking_number,
                freight_cost,
                additional_cost,
                consignment_charge,
                complete,
                order_url,
                source,
                external_id,
                payload_hash,
                payload_json
            ) VALUES (
                :event_datetime,
                :client_name,
                :order_id,
                :order_reference,
                :customer_name,
                :freight_company,
                :tracking_number,
                :freight_cost,
                :additional_cost,
                :consignment_charge,
                :complete,
                :order_url,
                :source,
                :external_id,
                :payload_hash,
                :payload_json
            )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':event_datetime'     => $event_datetime,
        ':client_name'        => $client_name,
        ':order_id'           => (int)$order_id,
        ':order_reference'    => $order_reference,
        ':customer_name'      => $customer_name,
        ':freight_company'    => $freight_company,
        ':tracking_number'    => $tracking_number,
        ':freight_cost'       => !empty($freight_cost) ? (float)$freight_cost : null,
        ':additional_cost'    => !empty($additional_cost) ? (float)$additional_cost : null,
        ':consignment_charge' => !empty($consignment_charge) ? (float)$consignment_charge : null,
        ':complete'           => (int)$complete,
        ':order_url'          => $order_url,
        ':source'             => $source,
        ':external_id'        => $external_id,
        ':payload_hash'       => $payload_hash,
        ':payload_json'       => $payload_json,
    ]);

    $shipment_id = $pdo->lastInsertId();

    // -------------------------------------------------------------------------
    // Return response
    // -------------------------------------------------------------------------
    http_response_code(201);
    echo json_encode([
        'success'     => true,
        'shipment_id' => $shipment_id,
        'message'     => 'Shipment created successfully'
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Database error: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ]);
    exit;
}

//Run:
//php create_shipment.php event_datetime=2024-06-01T12:00:00Z client_name=Alexandra order_id=123 order_reference=WEB-ORDER-77821 customer_name="Alexandra Boyles" freight_company="Test Company" tracking_number=TRN-12345 freight_cost=15.50 consignment_charge=5.00 complete=1 order_url=https://example.com/order/123 external_id=EXT-12345