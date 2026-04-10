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
    $id               = $_POST['id'] ?? null;             // UUID → Consignment.id
    $consignment_id   = $_POST['consignment_id'] ?? null;
    $saleOrder_id     = $_POST['saleOrder_id'] ?? null;
    $address_id       = $_POST['address_id'] ?? null;
    $product_id       = $_POST['product_id'] ?? null;
    $deliveryRun_id   = $_POST['deliveryRun_id'] ?? null;
    $driver_id        = $_POST['driver_id'] ?? null;
    $runsheet_id      = $_POST['runsheet_id'] ?? null;
    $service          = $_POST['service'] ?? null;
    $reference        = $_POST['reference'] ?? null;
    $is_residential   = $_POST['is_residential'] ?? null;
    $quantity         = $_POST['quantity'] ?? null;
    $cubic            = $_POST['cubic'] ?? null;
    $weight           = $_POST['weight'] ?? null;
    $pallets          = $_POST['pallets'] ?? null;
    $spaces           = $_POST['spaces'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id'             => $id,
        'consignment_id' => $consignment_id,
        'saleOrder_id'   => $saleOrder_id,
        'address_id'     => $address_id,
        'product_id'     => $product_id,
        'deliveryRun_id' => $deliveryRun_id,
        'driver_id'      => $driver_id,
        'runsheet_id'    => $runsheet_id,
        'service'        => $service,
        'reference'      => $reference,
        'is_residential' => $is_residential,
        'quantity'       => $quantity,
        'cubic'          => $cubic,
        'weight'         => $weight,
        'pallets'        => $pallets,
        'spaces'         => $spaces,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Consignment exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare('SELECT 1 FROM Consignment WHERE id = :id');
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Consignment does not exist');
    }

    // ---------------------------------------------------------------------
    // FK checks
    // ---------------------------------------------------------------------
    $tables = [
        'saleOrder'   => $saleOrder_id,
        'address'     => $address_id,
        'product'     => $product_id,
        'deliveryRun' => $deliveryRun_id,
        'driver'      => $driver_id,
        'runsheet'    => $runsheet_id,
    ];

    foreach ($tables as $table => $fkId) {
        $stmt = $pdo->prepare("SELECT 1 FROM {$table} WHERE id = :id");
        $stmt->execute([':id' => $fkId]);

        if ($stmt->fetchColumn() === false) {
            throw new RuntimeException(ucfirst($table) . ' does not exist');
        }
    }

    // ---------------------------------------------------------------------
    // Update Consignment
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE Consignment SET
            consignment_id = :consignment_id,
            saleOrder_id   = :saleOrder_id,
            address_id     = :address_id,
            product_id     = :product_id,
            deliveryRun_id = :deliveryRun_id,
            driver_id      = :driver_id,
            runsheet_id    = :runsheet_id,
            service        = :service,
            reference      = :reference,
            is_residential = :is_residential,
            quantity       = :quantity,
            cubic          = :cubic,
            weight         = :weight,
            pallets        = :pallets,
            spaces         = :spaces
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'             => $id,
        ':consignment_id' => $consignment_id,
        ':saleOrder_id'   => $saleOrder_id,
        ':address_id'     => $address_id,
        ':product_id'     => $product_id,
        ':deliveryRun_id' => $deliveryRun_id,
        ':driver_id'      => $driver_id,
        ':runsheet_id'    => $runsheet_id,
        ':service'        => $service,
        ':reference'      => $reference,
        ':is_residential' => $is_residential,
        ':quantity'       => $quantity,
        ':cubic'          => $cubic,
        ':weight'         => $weight,
        ':pallets'        => $pallets,
        ':spaces'         => $spaces,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('No changes were applied');
    }

    $pdo->commit();

    echo 'Consignment updated successfully. UUID: ' . $id;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update consignment: ' . $e->getMessage();
}

//Run: php update_consignment.php id=f57df92f-6513-4f54-a5d6-c4b881460ac1 consignment_id=1001 saleOrder_id=1510b98d-3470-11f1-92ef-00249b8cd187 address_id=b91e8d30-b0eb-4ca9-911c-750b538d57e7 product_id=702ed0e8-fbca-409e-9d15-7548c10f0ad3 deliveryRun_id=222e8400-e29b-41d4-a716-222222222222 driver_id=2bc93718-971b-487d-b1dd-8fb4f0a0b8ba runsheet_id=1 service="Standard Delivery" reference=PO-456789 is_residential=1 quantity=10 cubic=2.45 weight=350.75 pallets=1 spaces=2

