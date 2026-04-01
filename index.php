<?php
// Log uncaught exceptions
set_exception_handler(function ($exception) {
    $entry = date('c') . " | [UNCAUGHT EXCEPTION] " . get_class($exception) .
             " | " . $exception->getMessage() .
             " in " . $exception->getFile() . " on line " . $exception->getLine() . PHP_EOL;
    file_put_contents(__DIR__ . '/logs/runtime.log', $entry, FILE_APPEND);

    // Show short message only
    echo "[RUNTIME ERROR] Message: " . $exception->getMessage() . PHP_EOL;
});

// Log fatal errors
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null) {
        $entry = date('c') . " | [FATAL ERROR] {$error['message']} in {$error['file']} on line {$error['line']}" . PHP_EOL;
        file_put_contents(__DIR__ . '/logs/runtime.log', $entry, FILE_APPEND);

        // Show short message only
        echo "[RUNTIME ERROR] Message: {$error['message']}" . PHP_EOL;
    }
});


require __DIR__ . '/vendor/autoload.php';

use Addresses\Address;
use Contacts\Contact;
use Invoices\Invoice;
use Products\Product;
use Transport\Consignment;
use Warehouse\PurchaseOrder;

use Core\DeletionLogger;
use Core\PrintLogger;
use Logs\DeletionLog;
use Logs\PrintLog;
use Core\ValidationException;
use Core\RuntimeException;

// Instantiate loggers
$deletionLogger = new DeletionLogger();
$printLogger = new PrintLogger();

try {
    // --- Sample creation of objects across modules ---
    $address = new Address(1, "123 Main St", "Unit 4", "Brisbane", "QLD", "4000");
    $contact = new Contact(1, "Alice Smith", "alice@example.com", "0400123456");

    $invoice = new Invoice(101, 1, 5, 2001, 1500.00, 1200.00, "2026-03-01", "2026-03-31", "Open", "Pending", "Sent", "INT-REF-001", "EXT-REF-001");

    $product = new Product(501, 1, "Widget A", "High quality widget", "SKU-12345", "", "Box", 10.0, 5.0, 3.0, 2.5);

    $consignment = new Consignment(301, 101, 1, 501, 401, 201, 601, "Express", "REF-789", true, 10, 2.5, 25.0, 2, 5);

    $purchaseOrder = new PurchaseOrder(701, 1, "PO-REF-001", "CUST-REF-001", "Warehouse A", "456 Supply Rd, Brisbane", "2026-03-20", [$product], "Pending");

    // --- Sample logging actions ---
    $delLog = new DeletionLog("Address", $address->getId(), "admin", date('Y-m-d'));
    $deletionLogger->log("Deleted Address", $delLog->toArray());

    $printLog = new PrintLog("Invoice Print", "Invoice #101", "HP-LaserJet", "PC-01", "Warehouse A");
    $printLogger->log("Printed Invoice", $printLog->toArray());

    // --- Output objects neatly ---
    function prettyPrint($title, $object) {
        echo "=== $title ===" . PHP_EOL;
        echo json_encode($object->toArray(), JSON_PRETTY_PRINT) . PHP_EOL . PHP_EOL;
    }

    prettyPrint("Address", $address);
    prettyPrint("Contact", $contact);
    prettyPrint("Invoice", $invoice);
    prettyPrint("Product", $product);
    prettyPrint("Consignment", $consignment);
    prettyPrint("Purchase Order", $purchaseOrder);

} catch (ValidationException $ve) {
    echo "[VALIDATION ERROR] Field: " . $ve->getField() . " | Message: " . $ve->getMessage() . PHP_EOL;
    file_put_contents(__DIR__ . '/logs/validation.log', date('c') . " | " . $ve->getMessage() . PHP_EOL, FILE_APPEND);

} catch (RuntimeException $re) {
    echo "[RUNTIME ERROR] Context: " . $re->getContext() . " | Message: " . $re->getMessage() . PHP_EOL;
    file_put_contents(__DIR__ . '/logs/runtime.log', date('c') . " | " . $re->getMessage() . PHP_EOL, FILE_APPEND);
}














//TEST
// require __DIR__ . '/vendor/autoload.php';

// use Core\DeletionLogger;

// $logger = new DeletionLogger();
// $logger->log("Test deletion", ["id" => 123]);







// Project Summary
// -This is a PHP business application project focused on logistics, invoices, transport, warehouse, and related domain models.
//What it contains:
// -index.php
    // Example entry point that constructs sample domain objects
    // Demonstrates Address, Contact, Invoice, Product, Consignment, PurchaseOrder
    // Shows logging with DeletionLogger and PrintLogger
    // Prints object data and handles validation/runtime exceptions
// -src
    // Main namespaced source code for core business modules and components
// -Core/core
    // Base classes, logger helpers, runtime and validation exception support
// -tests
    // PHPUnit test cases for models and validation
// -logs
    // Logs are written with deletion.log, print.log, validation.log, and runtime.log for structured logging for the different types of events and errors
// -readme.md
    //provides project overview, and setup instructions
//Domain areas represented
    // Addresses and contacts
    // Invoicing and billing
    // Products and product metadata
    // Transport / consignments
    // Warehouse operations / purchase orders
//Configuration
    //vendor/autoload.php for autoloading classes via Composer for namespace mappings for Core, Addresses, Invoices, Products, Transport, WarehouseSettings configured in composer.json
    //phpunit.xml for test configuration and test suite caching
//Purpose
    // This project is a sample or small application for managing logistics-related entities and workflows, with:
        // object modeling for business entities
        // validation and logging
        // test coverage via PHPUnit