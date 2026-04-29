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
    $id             = $_POST['id'] ?? null;
    $customer_id    = $_POST['customer_id'] ?? null; // UUID → Customer.id
    $rates          = $_POST['rates'] ?? null;
    $contact_email  = $_POST['contact_email'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
        'id'            => $id,
        'customer_id'   => $customer_id,
        'rates'         => $rates,
        'contact_email' => $contact_email,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
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
    // Insert Rate Card
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO rateCard (
            id,
            customer_id,
            rates,
            contact_email
        ) VALUES (
            :id,
            :customer_id,
            :rates,
            :contact_email
        )'
    );

    $stmt->execute([
        ':id'            => $id,
        ':customer_id'   => $customer_id,
        ':rates'         => $rates,
        ':contact_email' => $contact_email,
    ]);

    $pdo->commit();

    echo 'Rate Card created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create rate card: ' . $e->getMessage();
};

//Run: php create_rateCard.php id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 rates="Standard Shipping Rate" contact_email=billing@acme.com