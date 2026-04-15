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
    $feeCategory_name = $_POST['feeCategory_name'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($feeCategory_name === null || trim($feeCategory_name) === '') {
        throw new InvalidArgumentException('Fee Category name is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Fee Category exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM feeCategory WHERE feeCategory_name = :feeCategory_name'
    );
    $check->execute([':feeCategory_name' => $feeCategory_name]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Fee Category does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete Fee Category
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'DELETE FROM feeCategory WHERE feeCategory_name = :feeCategory_name'
    );

    $stmt->execute([
        ':feeCategory_name' => $feeCategory_name
    ]);

    $pdo->commit();

    echo 'Fee Category deleted successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete fee category: ' . $e->getMessage();
}

//Run: php delete_feeCategory.php feeCategory_name="Laboratory Fee"