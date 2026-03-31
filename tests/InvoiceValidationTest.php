<?php
use PHPUnit\Framework\TestCase;
use Invoices\Invoice;

class InvoiceValidationTest extends TestCase {
    public function testEndDateBeforeStartDateThrowsError() {
        $this->expectException(\InvalidArgumentException::class);
        new Invoice(
            101, 1, 5, 2001, 1500.00, 1200.00,
            "2026-04-01", "2026-03-01", // invalid: end before start
            "Open", "Pending", "Sent", "INT-REF-001", "EXT-REF-001"
        );
    }

    public function testNegativeIncomeThrowsError() {
        $this->expectException(\InvalidArgumentException::class);
        new Invoice(
            102, 1, 5, 2002, -100.00, 1200.00, // invalid: negative income
            "2026-03-01", "2026-03-31",
            "Open", "Pending", "Sent", "INT-REF-002", "EXT-REF-002"
        );
    }
}
