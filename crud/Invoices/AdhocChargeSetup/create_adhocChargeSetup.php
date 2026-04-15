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
    $id                    = $_POST['id'] ?? null;
    $adhocChargeSetup_name = $_POST['adhocChargeSetup_name'] ?? null;
    $chargeStructure       = $_POST['chargeStructure'] ?? null;
    $rate                  = $_POST['rate'] ?? null;
    $descriptionTemplate   = $_POST['descriptionTemplate'] ?? null;
    $is_enabled            = $_POST['is_enabled'] ?? null;
    $pageVisionOn          = $_POST['pageVisionOn'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input (ALL fields required by schema)
    // ---------------------------------------------------------------------
    foreach ([
        'id'                    => $id,
        'adhocChargeSetup_name' => $adhocChargeSetup_name,
        'chargeStructure'       => $chargeStructure,
        'rate'                  => $rate,
        'descriptionTemplate'   => $descriptionTemplate                                       ,
        'is_enabled'            => $is_enabled,
        'pageVisionOn'          => $pageVisionOn,
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Insert Adhoc Charge Setup
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'INSERT INTO adhocChargeSetup (
            id,
            adhocChargeSetup_name,
            chargeStructure,
            rate,
            descriptionTemplate,
            is_enabled,
            pageVisionOn
        ) VALUES (
            :id,
            :adhocChargeSetup_name,
            :chargeStructure,
            :rate,
            :descriptionTemplate,
            :is_enabled,
            :pageVisionOn
        )'
    );

    $stmt->execute([
        ':id'                    => $id,
        ':adhocChargeSetup_name' => $adhocChargeSetup_name,
        ':chargeStructure'       => $chargeStructure,
        ':rate'                  => $rate,
        ':descriptionTemplate'   => $descriptionTemplate,
        ':is_enabled'            => $is_enabled,
        ':pageVisionOn'          => $pageVisionOn,
    ]);

    $pdo->commit();

    echo 'Adhoc Charge Setup created successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to create adhoc charge setup: ' . $e->getMessage();
};


//Run: php create_adhocChargeSetup.php id=1001 adhocChargeSetup_name="Late Payment Fee" chargeStructure="Flat Rate" rate=150 descriptionTemplate="Late payment charge" is_enabled=1 pageVisionOn=Billing