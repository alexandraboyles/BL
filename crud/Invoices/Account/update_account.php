<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
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
    $description = $_POST['description'] ?? null;
    $display_when_no_value = $_POST['display_when_no_value'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'account_name'  => $account_name,
        'description'  => $description,
        'display_when_no_value'  => $display_when_no_value,
    ] as $field => $value) {
        if ($value === null || trim((string)$value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Update Account
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE account SET
            account_name  = :account_name,
            description = :description,
            display_when_no_value = :display_when_no_value'
    );

    $stmt->execute([
        ':account_name'  => $account_name,
        ':description'  => $description,
        ':display_when_no_value'   => $display_when_no_value,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('No changes were applied');
    }

    $pdo->commit();

    echo 'Account updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update account: ' . $e->getMessage();
}

//Run: php update_account.php account_name="Mark Manos" description="Test test" display_when_no_value=0