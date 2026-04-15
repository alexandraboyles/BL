<?php
declare(strict_types=1);

// ------------------------------------------------------------
// Allow CLI arguments like key=value&key2=value2
// ------------------------------------------------------------
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
    $id = $_POST['id'] ?? null; // rateCard.id

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id === null || trim($id) === '') {
        throw new InvalidArgumentException('id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Rate Card exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM rateCard WHERE id = :id'
    );
    $check->execute([':id' => $id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Rate Card does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete Rate Card
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'DELETE FROM rateCard WHERE id = :id'
    );

    $stmt->execute([
        ':id' => $id
    ]);

    $pdo->commit();

    echo 'Rate Card deleted successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete rate card: ' . $e->getMessage();
}

//Run: php delete_rateCard.php id=1002