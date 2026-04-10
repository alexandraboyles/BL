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
    $id          = $_POST['id'] ?? null;           // supplier.id
    $rateCardId  = $_POST['rateCard_id'] ?? null; // rateCard.id (FK)
    $email       = $_POST['email'] ?? null;

    if (
        ($id === null || trim($id) === '') &&
        ($rateCardId === null || trim($rateCardId) === '') &&
        ($email === null || trim($email) === '')
    ) {
        throw new InvalidArgumentException(
            'At least one filter is required: id, rateCard_id, or email'
        );
    }

    // -----------------------------------------------------------------
    // Build dynamic query
    // Priority: id > rateCard_id > email
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {

        $sql = '
            SELECT
                id,
                rateCard_id,
                companyName,
                email,
                telNo,
                accountingConnector
            FROM supplier
            WHERE id = :id
        ';

        $params = [
            ':id' => $id,
        ];

    } elseif ($rateCardId !== null && trim($rateCardId) !== '') {

        // Optional FK safety check
        $check = $pdo->prepare('SELECT 1 FROM rateCard WHERE id = :id');
        $check->execute([':id' => $rateCardId]);

        if ($check->fetchColumn() === false) {
            throw new RuntimeException('Rate Card does not exist');
        }

        $sql = 'SELECT
                id,
                rateCard_id,
                companyName,
                email,
                telNo,
                accountingConnector
            FROM supplier
            WHERE rateCard_id = :rateCard_id
            ORDER BY companyName';

        $params = [
            ':rateCard_id' => $rateCardId,
        ];

    } else {
        // email filter
        $sql = 'SELECT
                id,
                rateCard_id,
                companyName,
                email,
                telNo,
                accountingConnector
            FROM supplier
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
            'message' => 'No supplier(s) found',
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
//Read supplier by ID
    //php read_supplier.php id=1
//List all suppliers for a rate card
    //php read_supplier.php rateCard_id=5
//Lookup supplier by email
    //php read_supplier.php email=tro_updated@gmail.com