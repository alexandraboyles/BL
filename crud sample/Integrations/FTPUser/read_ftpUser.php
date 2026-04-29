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
    $ftpUserId = $_POST['ftpUser_id'] ?? null; // integer

    if (
        ($id === null || trim($id) === '') &&
        ($ftpUserId === null || trim((string)$ftpUserId) === '')
    ) {
        throw new InvalidArgumentException(
            'Either id (UUID) or ftpUser_id is required'
        );
    }

    // -----------------------------------------------------------------
    // Build query dynamically
    // -----------------------------------------------------------------
    if ($id !== null && trim($id) !== '') {
        $sql = 'SELECT
                    id,
                    ftpUser_id,
                    username,
                    password,
                    subDirectory
                FROM ftpUser
                WHERE id = :id';

        $params = [
            ':id' => $id,
        ];
    } else {
        if (!ctype_digit((string)$ftpUserId)) {
            throw new InvalidArgumentException('ftpUser_id must be an integer');
        }

        $sql = 'SELECT
                    id,
                    ftpUser_id,
                    username,
                    password,
                    subDirectory
                FROM ftpUser
                WHERE ftpUser_id = :ftpUser_id';

        $params = [
            ':ftpUser_id' => (int)$ftpUserId,
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
            'message' => 'No ftpUser found',
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
//Read single ftpUser by id
    //php read_ftpUser.php ftpUser_id=1001
//Read single ftpUser by UUID
    //php read_ftpUser.php id=63579635-1ac7-4051-8c9f-8f5d0ad8303c