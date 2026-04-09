<?php
use PHPUnit\Framework\TestCase;
use Warehouse\PurchaseOrder;
use Products\Product;

class PurchaseOrderValidationTest extends TestCase {
    public function testQuantityMustBeGreaterThanZero() {
        $this->expectException(\InvalidArgumentException::class);
        $product = new Product(
            501, 1, "Widget A", "High quality widget", "SKU-12345",
            "2026-03-15", "Box", 10.0, 5.0, 3.0, 2.5
        );
        new PurchaseOrder(
            701, 1, 123, "CUST-REF-001", "Warehouse A",
            "456 Supply Rd, Brisbane", "2026-03-20",
            [$product], "Pending"
        ); //numeric order reference
    }
}
