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

require __DIR__ . '/../../db_connect.php';

try {
    // -----------------------------------------------------------------
    // Collect input
    // -----------------------------------------------------------------
    $id         = $_POST['id'] ?? null;          // Contact UUID
    $customerId = $_POST['customer_id'] ?? null; // Customer UUID
    $email      = $_POST['email'] ?? null;

    if (
        ($id === null || trim($id) === '') &&
        ($customerId === null || trim($customerId) === '') &&
        ($email === null || trim($email) === '')
    ) {
        throw new InvalidArgumentException(
            'At least one filter is required: id, customer_id, or email'
        );
    }

    // -----------------------------------------------------------------
    // Build dynamic query
    // Priority: id > customer_id > email
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {
        $sql = 'SELECT
                    id,
                    customer_id,
                    contact_name,
                    email,
                    phone
                FROM Contact
                WHERE id = :id';

        $params = [
            ':id' => $id,
        ];

    } elseif ($customerId !== null && trim($customerId) !== '') {

        // Optional FK safety check (mirrors create_contact.php)
        $check = $pdo->prepare('SELECT 1 FROM Customer WHERE id = :id');
        $check->execute([':id' => $customerId]);

        if ($check->fetchColumn() === false) {
            throw new RuntimeException('Customer does not exist');
        }

        $sql = 'SELECT
                    id,
                    customer_id,
                    contact_name,
                    email,
                    phone
                FROM Contact
                WHERE customer_id = :customer_id
                ORDER BY contact_name';

        $params = [
            ':customer_id' => $customerId,
        ];

    } else {
        // email lookup
        $sql = 'SELECT
                    id,
                    customer_id,
                    contact_name,
                    email,
                    phone
                FROM Contact
                WHERE email = :email';

        $params = [
            ':email' => $email,
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
            'message' => 'No contact(s) found',
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
};

//Run:
//Read single contact by UUID 
//php read_contact.php id=64602649-5615-43f3-922c-8f4ff054eef6
//List all contacts for a customer
//php read_contact.php customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187