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
    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $address_id = $_POST['address_id'] ?? null; // UUID → Address.id
    $customer_id = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $deliveryInstruction  = $_POST['deliveryInstruction'] ?? null;
    $packingInstruction   = $_POST['packingInstruction'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'address_id' => $address_id,
        'customer_id' => $customer_id,
        'deliveryInstruction' => $deliveryInstruction,
        'packingInstruction'  => $packingInstruction,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Address exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Address WHERE id = :id'
    );
    $check->execute([':id' => $address_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Address does not exist');
    }

    
    // ---------------------------------------------------------------------
    // Ensure Customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Customer WHERE id = :id'
    );
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Insert Address Default Instruction
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO addressDefaultInstruction (
            address_id,
            customer_id,
            deliveryInstruction,
            packingInstruction
        ) VALUES (
            :address_id,
            :customer_id,
            :deliveryInstruction,
            :packingInstruction
        )'
    );

    $stmt->execute([
        ':address_id'          => $address_id,
        ':customer_id' => $customer_id,
        ':deliveryInstruction' => $deliveryInstruction,
        ':packingInstruction'  => $packingInstruction,
    ]);

    $pdo->commit();

    echo 'Address Default Instruction created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create address default instruction: ' . $e->getMessage();
};


//Run: php create_addressDefaultInstruction.php address_id=adad3ec5-fe9f-4375-88c5-defbfe042c7f customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 deliveryInstruction=Test test 2 packingInstruction=Pick up from: MANILA Logistics Warehouse.