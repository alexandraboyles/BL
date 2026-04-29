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
    $account_name = $_POST['account_name'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    if ($account_name === null || trim($account_name) === '') {
        throw new InvalidArgumentException('Account name is required');
    }

    // ---------------------------------------------------------------------
    // Ensure Account name exists
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM account WHERE account_name = :account_name'
    );
    $check->execute([':account_name' => $account_name]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Account name does not exist');
    }

    // ---------------------------------------------------------------------
    // Delete Account
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'DELETE FROM account WHERE account_name = :account_name'
    );

    $stmt->execute([
        ':account_name' => $account_name
    ]);

    $pdo->commit();

    echo 'Account deleted successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to delete account: ' . $e->getMessage();
}

//Run: php delete_account.php account_name="Mark Manos"