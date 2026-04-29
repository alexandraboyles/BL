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
    $appliesTo                     = $_POST['appliesTo'] ?? null;
    $account                       = $_POST['account'] ?? null;
    $feeCategory_name              = $_POST['feeCategory_name'] ?? null;
    $counts_toward_minimum_charges = $_POST['counts_toward_minimum_charges'] ?? null;
    $is_name_editable              = $_POST['is_name_editable'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'appliesTo'                     => $appliesTo,
        'account'                       => $account,
        'feeCategory_name'              => $feeCategory_name,
        'counts_toward_minimum_charges' => $counts_toward_minimum_charges,
        'is_name_editable'              => $is_name_editable,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Insert Fee Category 
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO feeCategory (
            appliesTo,
            account,
            feeCategory_name,
            counts_toward_minimum_charges,
            is_name_editable
        ) VALUES (
            :appliesTo,
            :account,
            :feeCategory_name,
            :counts_toward_minimum_charges,
            :is_name_editable
        )'
    );

    $stmt->execute([
        ':appliesTo'                     => $appliesTo,
        ':account'                       => $account,
        ':feeCategory_name'              => $feeCategory_name,
        ':counts_toward_minimum_charges' => $counts_toward_minimum_charges,
        ':is_name_editable'              => $is_name_editable,
    ]);

    $pdo->commit();

    echo 'Fee category created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create fee category: ' . $e->getMessage();
};


//Run: php create_feeCategory.php appliesTo=Student account="Laboratory Fees" feeCategory_name="Laboratory Fee" counts_toward_minimum_charges=1 is_name_editable=1
