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
    // -----------------------------------------------------------------
    // Collect input
    // -----------------------------------------------------------------
    $id            = $_POST['id'] ?? null;            // Customer UUID
    $customerName  = $_POST['customer_name'] ?? null;
    $email         = $_POST['contact_email'] ?? null;

    if (
        ($id === null || trim($id) === '') &&
        ($customerName === null || trim($customerName) === '') &&
        ($email === null || trim($email) === '')
    ) {
        throw new InvalidArgumentException(
            'At least one filter is required: id, customer_name, or contact_email'
        );
    }

    // -----------------------------------------------------------------
    // Build dynamic query
    // Priority: id > customer_name > contact_email
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {

        $sql = 'SELECT
                    id,
                    customer_name,
                    contact_phone,
                    contact_email
                FROM Customer
                WHERE id = :id';

        $params = [
            ':id' => $id,
        ];

    } elseif ($customerName !== null && trim($customerName) !== '') {

        $sql = 'SELECT
                    id,
                    customer_name,
                    contact_phone,
                    contact_email
                FROM Customer
                WHERE customer_name LIKE :customer_name
                ORDER BY customer_name';

        $params = [
            ':customer_name' => '%' . $customerName . '%',
        ];

    } else {
        // contact_email lookup
        $sql = 'SELECT
                    id,
                    customer_name,
                    contact_phone,
                    contact_email
                FROM Customer
                WHERE contact_email = :contact_email';

        $params = [
            ':contact_email' => $email,
        ];
    }

    // -----------------------------------------------------------------
    // Execute
    // -----------------------------------------------------------------
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // -----------------------------------------------------------------
    // Output
    // -----------------------------------------------------------------
    if (!$rows) {
        echo json_encode([
            'success' => true,
            'data'    => [],
            'message' => 'No customer(s) found',
        ], JSON_PRETTY_PRINT);
        exit;
    }

    echo json_encode([
        'success' => true,
        'data'    => $rows,
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    header('Content-Type: application/json', true, 400);

    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage(),
    ], JSON_PRETTY_PRINT);
}

//Run: 
//Read customer by UUID
    //php read_customer.php id=ddf497c2-480c-4fc8-bbcd-dd5a5c5478c1
//Search customers by name (partial match)
    //php read_customer.php customer_name=Alexandra
//Read customer by email
    //php read_customer.php contact_email=alex_updated@gmail.com