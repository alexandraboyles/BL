<?php
use PHPUnit\Framework\TestCase;
use Core\DeletionLogger;
use Core\PrintLogger;
use Logs\DeletionLog;
use Logs\PrintLog;

class LoggerTest extends TestCase {
    public function testDeletionLoggerWritesLog() {
        $logger = new DeletionLogger();
        $log = new DeletionLog("Address", "ADDR-001", "admin", date('Y-m-d'));

        ob_start();
        $logger->log("Deleted Address", $log->toArray());
        $output = ob_get_clean();

        $this->assertStringContainsString("Deleted Address", $output);
        $this->assertStringContainsString("ADDR-001", $output);
    }

    public function testPrintLoggerWritesLog() {
        $logger = new PrintLogger();
        $log = new PrintLog("Invoice Print", "Invoice #101", "HP-LaserJet", "PC-01", "Warehouse A");

        ob_start();
        $logger->log("Printed Invoice", $log->toArray());
        $output = ob_get_clean();

        $this->assertStringContainsString("Printed Invoice", $output);
        $this->assertStringContainsString("Invoice #101", $output);
    }
}
