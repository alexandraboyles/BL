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
    // Note: id, received_at, created_at, updated_at are not updatable
    // -------------------------------------------------------------------------
    $id                 = $_POST['id'] ?? null;
    $client_name        = $_POST['client_name'] ?? null;
    $order_id           = $_POST['order_id'] ?? null;
    $order_reference    = $_POST['order_reference'] ?? null;
    $customer_name      = $_POST['customer_name'] ?? null;
    $freight_company    = $_POST['freight_company'] ?? null;
    $tracking_number    = $_POST['tracking_number'] ?? null;
    $freight_cost       = $_POST['freight_cost'] ?? null;
    $consignment_charge = $_POST['consignment_charge'] ?? null;
    $complete           = $_POST['complete'] ?? null;
    $order_url          = $_POST['order_url'] ?? null;
    $external_id        = $_POST['external_id'] ?? null;
    $event_datetime     = $_POST['event_datetime'] ?? null;
    $additional_cost    = $_POST['additional_cost'] ?? null;
    $source             = $_POST['source'] ?? null;
    $payload_hash       = $_POST['payload_hash'] ?? null;
    $payload_json       = $_POST['payload_json'] ?? null;

    // -------------------------------------------------------------------------
    // Validate required fields
    // -------------------------------------------------------------------------
    $required_fields = [
        'id'                 => $id,
        'client_name'        => $client_name,
        'order_id'           => $order_id,
        'order_reference'    => $order_reference,
        'customer_name'      => $customer_name,
        'freight_company'    => $freight_company,
        'tracking_number'    => $tracking_number,
        'freight_cost'       => $freight_cost,
        'consignment_charge' => $consignment_charge,
        'complete'           => $complete,
        'order_url'          => $order_url,
        'external_id'        => $external_id,
    ];

    $errors = [];
    foreach ($required_fields as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            $errors[] = "$field is required";
        }
    }

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // -------------------------------------------------------------------------
    // Validate data types
    // -------------------------------------------------------------------------
    if (!is_numeric($id) || $id <= 0) {
        throw new InvalidArgumentException('id must be a positive integer');
    }

    // -------------------------------------------------------------------------
    // Ensure Shipment exists
    // -------------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM shipments WHERE id = :id');
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Shipments does not exist');
    }

    // -------------------------------------------------------------------------
    // Validate data types
    // -------------------------------------------------------------------------
    if (!is_numeric($order_id) || $order_id <= 0) {
        throw new InvalidArgumentException('order_id must be a positive integer');
    }

    if (!is_numeric($freight_cost)) {
        throw new InvalidArgumentException('freight_cost must be numeric');
    }

    if (!is_numeric($consignment_charge)) {
        throw new InvalidArgumentException('consignment_charge must be numeric');
    }

    if (!in_array((int)$complete, [0, 1])) {
        throw new InvalidArgumentException('complete must be 0 or 1');
    }

    // -------------------------------------------------------------------------
    // Validate optional fields (if provided)
    // -------------------------------------------------------------------------
    if ($event_datetime !== null && !is_string($event_datetime)) {
        throw new InvalidArgumentException('event_datetime must be a valid datetime string');
    }

    if ($additional_cost !== null && !is_numeric($additional_cost)) {
        throw new InvalidArgumentException('additional_cost must be numeric');
    }

    // -------------------------------------------------------------------------
    // Convert payload_json if string
    // -------------------------------------------------------------------------
    if ($payload_json !== null && is_string($payload_json)) {
        $payload_json = json_validate($payload_json) ? $payload_json : null;
    }

    // -------------------------------------------------------------------------
    // Build UPDATE statement with all provided fields
    // -------------------------------------------------------------------------
    $sql = "UPDATE shipments SET 
                client_name = :client_name,
                order_id = :order_id,
                order_reference = :order_reference,
                customer_name = :customer_name,
                freight_company = :freight_company,
                tracking_number = :tracking_number,
                freight_cost = :freight_cost,
                consignment_charge = :consignment_charge,
                complete = :complete,
                order_url = :order_url,
                external_id = :external_id";

    $params = [
        ':id'                => (int)$id,
        ':client_name'       => $client_name,
        ':order_id'          => (int)$order_id,
        ':order_reference'   => $order_reference,
        ':customer_name'     => $customer_name,
        ':freight_company'   => $freight_company,
        ':tracking_number'   => $tracking_number,
        ':freight_cost'      => (float)$freight_cost,
        ':consignment_charge' => (float)$consignment_charge,
        ':complete'          => (int)$complete,
        ':order_url'         => $order_url,
        ':external_id'       => $external_id,
    ];

    // Add optional fields if provided
    if ($event_datetime !== null) {
        $sql .= ", event_datetime = :event_datetime";
        $params[':event_datetime'] = $event_datetime;
    }

    if ($additional_cost !== null) {
        $sql .= ", additional_cost = :additional_cost";
        $params[':additional_cost'] = (float)$additional_cost;
    }

    if ($source !== null) {
        $sql .= ", source = :source";
        $params[':source'] = $source;
    }

    if ($payload_hash !== null) {
        $sql .= ", payload_hash = :payload_hash";
        $params[':payload_hash'] = $payload_hash;
    }

    if ($payload_json !== null) {
        $sql .= ", payload_json = :payload_json";
        $params[':payload_json'] = $payload_json;
    }

    $sql .= " WHERE id = :id";

    // -------------------------------------------------------------------------
    // Execute update
    // -------------------------------------------------------------------------
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $affected_rows = $stmt->rowCount();

    // -------------------------------------------------------------------------
    // Return response
    // -------------------------------------------------------------------------
    http_response_code(200);
    echo json_encode([
        'success'       => true,
        'shipment_id'   => (int)$id,
        'affected_rows' => $affected_rows,
        'message'       => 'Shipment updated successfully'
    ]);

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
} catch (RuntimeException $e) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
}

//Run: php update_purchaseOrder.php id=1 client_name=Alexandra order_id=123 order_reference=WEB-ORDER-77821 customer_name="Alexandra Boyles" freight_company="Test Company" tracking_number=TRN-12345 freight_cost=15.50 consignment_charge=5.00 complete=1 order_url=https://example.com/order/123 external_id=EXT-12345