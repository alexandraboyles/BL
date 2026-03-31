<?php
use PHPUnit\Framework\TestCase;
use Invoices\Invoice;

class InvoiceTest extends TestCase {
    public function testInvoiceCreation() {
        $invoice = new Invoice(
            101, 1, 5, 2001, 1500.00, 1200.00,
            "2026-03-01", "2026-03-31",
            "Open", "Pending", "Sent", "INT-REF-001", "EXT-REF-001"
        );

        $this->assertEquals(101, $invoice->invoiceId);
        $this->assertEquals("Open", $invoice->status);
        $this->assertEquals("Pending", $invoice->paymentStatus);
    }
}
