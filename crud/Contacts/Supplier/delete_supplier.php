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

    // ---------------------------------------------------------------------
    // Collect input
    // ---------------------------------------------------------------------
    $id = $_POST['id'] ?? null; 

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($id === null || trim((string)$id) === '') {
        throw new InvalidArgumentException('id is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Supplier exists
    // ---------------------------------------------------------------------
    $stmt = $pdo->prepare(
        'SELECT id
         FROM supplier
         WHERE id = :id'
    );

    $stmt->execute([':id' => $id,]);

    $supplierId = $stmt->fetchColumn();

    if ($supplierId === false) {
        throw new RuntimeException('Supplier does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete Supplier
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $delete = $pdo->prepare(
        'DELETE FROM supplier WHERE id = :id'
    );

    $delete->execute([
        ':id' => $supplierId,
    ]);

    $pdo->commit();

    echo 'Supplier deleted successfully. ID: ' . $supplierId;

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete supplier: ' . $e->getMessage();
}

//Run: php delete_supplier.php id=4
