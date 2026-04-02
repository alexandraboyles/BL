<?php
use PHPUnit\Framework\TestCase;
use Core\DeletionLogger;
use Core\PrintLogger;
use Logs\DeletionLog;
use Logs\PrintLog;
use Addresses\Address;

class LoggerTest extends TestCase {
    public function testDeletionLoggerWritesLog() {
        $logger = new DeletionLogger();
        $log = new DeletionLog("Address", "ADDR-001", "admin", date('Y-m-d'));

        $logger->log("Test - Deleted Address", $log->toArray());

        $logContents = file_get_contents(__DIR__ . '/../logs/deletion.log');
        $this->assertStringContainsString("Deleted Address", $logContents);
        $this->assertStringContainsString("ADDR-001", $logContents);
    }

    public function testPrintLoggerWritesLog() {
        $logger = new PrintLogger();
        $log = new PrintLog("Invoice Print", "Invoice #101", "HP-LaserJet", "PC-01", "Warehouse A");

        $logger->log("Test - Printed Invoice", $log->toArray());

        $logContents = file_get_contents(__DIR__ . '/../logs/print.log');
        $this->assertStringContainsString("Printed Invoice", $logContents);
        $this->assertStringContainsString("Invoice #101", $logContents);
    }
}
