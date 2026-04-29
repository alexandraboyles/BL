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
    $id        = $_POST['id'] ?? null;          // UUID
    $addressId = $_POST['address_id'] ?? null; // integer

    if (
        ($id === null || trim($id) === '') &&
        ($addressId === null || trim((string)$addressId) === '')
    ) {
        throw new InvalidArgumentException(
            'Either id (UUID) or address_id is required'
        );
    }

    // -----------------------------------------------------------------
    // Build query dynamically
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {
        $sql = 'SELECT
                    id,
                    address_id,
                    street_1,
                    street_2,
                    suburb,
                    state,
                    postcode
                FROM Address
                WHERE id = :id';

        $params = [
            ':id' => $id,
        ];
    } else {
        if (!ctype_digit((string)$addressId)) {
            throw new InvalidArgumentException('address_id must be an integer');
        }

        $sql = 'SELECT
                    id,
                    address_id,
                    street_1,
                    street_2,
                    suburb,
                    state,
                    postcode
                FROM Address
                WHERE address_id = :address_id';

        $params = [
            ':address_id' => (int)$addressId,
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
            'message' => 'No address found',
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
//Read single address by id
    //php read_address.php address_id=1001
//Read single address by UUID
    //php read_address.php id=adad3ec5-fe9f-4375-88c5-defbfe042c7f