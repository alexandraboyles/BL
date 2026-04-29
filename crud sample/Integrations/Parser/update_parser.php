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
    $id                 = $_POST['id'] ?? null; // parser.id
    $customer_id        = $_POST['customer_id'] ?? null; // Customer.id
    $parser_name        = $_POST['parser_name'] ?? null;
    $className          = $_POST['className'] ?? null;
    $class              = $_POST['class'] ?? null;
    $type               = $_POST['type'] ?? null;
    $acceptedFileTypes  = $_POST['acceptedFileTypes'] ?? null;
    $toAddress          = $_POST['toAddress'] ?? null;

    // ---------------------------------------------------------------------
    // Validate input
    // ---------------------------------------------------------------------
    foreach ([
        'id'                => $id,
        'customer_id'       => $customer_id,
        'parser_name'       => $parser_name,
        'className'         => $className,
        'type'              => $type,
        'acceptedFileTypes' => $acceptedFileTypes,
        'toAddress'         => $toAddress
    ] as $field => $value) {
        if ($value === null || trim($value) === '') {
            throw new InvalidArgumentException("$field is required");
        }
    }

    // ---------------------------------------------------------------------
    // Ensure Customer exists (FK safety)
    // ---------------------------------------------------------------------
    $check = $pdo->prepare(
        'SELECT 1 FROM Customer WHERE id = :id'
    );
    $check->execute([':id' => $customer_id]);

    if ($check->fetchColumn() === false) {
        throw new RuntimeException('Customer does not exist');
    }

    // ---------------------------------------------------------------------
    // Update Parser
    // ---------------------------------------------------------------------
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'UPDATE parser
         SET
            customer_id        = :customer_id,
            parser_name        = :parser_name,
            className          = :className,
            class              = :class,
            type               = :type,
            acceptedFileTypes  = :acceptedFileTypes,
            toAddress          = :toAddress
         WHERE id = :id'
    );

    $stmt->execute([
        ':id'                => $id,
        ':customer_id'       => $customer_id,
        ':parser_name'       => $parser_name,
        ':className'         => $className,
        ':class'             => $class,
        ':type'              => $type,
        ':acceptedFileTypes' => $acceptedFileTypes,
        ':toAddress'         => $toAddress,
    ]);

    $pdo->commit();

    echo 'Parser updated successfully.';

} catch (Throwable $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Failed to update parser: ' . $e->getMessage();
}

//Run: php update_parser.php id=1001 customer_id=64ed8b3e-3247-11f1-92ef-00249b8cd187 parser_name="Invoice PDF Parser" className=InvoiceParserUpdated class=com.company.parsers.InvoiceParser type=PDF acceptedFileTypes=pdf toAddress=invoices@company.com