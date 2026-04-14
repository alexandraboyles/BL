<?php
declare(strict_types=1);

// Allow CLI arguments like key=value&key2=value2
if (PHP_SAPI === 'cli') {
    foreach (array_slice($argv, 1) as $arg) {
        parse_str($arg, $parsed);
        $_POST = array_merge($_POST, $parsed);
    }
};

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
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Insert Account
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO account (
            account_name,
            description,
            display_when_no_value
        ) VALUES (
            :account_name,
            :description,
            :display_when_no_value
        )'
    );

    $stmt->execute([
        ':account_name'  => $account_name,
        ':description'  => $description,
        ':display_when_no_value'   => $display_when_no_value,
    ]);

    $pdo->commit();

    echo 'Account created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create account: ' . $e->getMessage();
};


//Run: php create_account.php account_name="Mark Dinglasa" description="Test test test" display_when_no_value=0