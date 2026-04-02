<?php
use PHPUnit\Framework\TestCase;
use Warehouse\PurchaseOrder;
use Products\Product;

class PurchaseOrderTest extends TestCase {
    public function testPurchaseOrderCreation() {
        $product = new Product(
            501, 1, "Widget A", "High quality widget", "SKU-12345",
            "2026-03-15", "Box", 10.0, 5.0, 3.0, 2.5
        );

        $purchaseOrder = new PurchaseOrder(
            701, 1, "PO-REF-001", "CUST-REF-001", "Warehouse A",
            "456 Supply Rd, Brisbane", "2026-03-20",
            [$product], "Pending"
        );

        $this->assertEquals("PO-REF-001", $purchaseOrder->getOrderReference());
        $this->assertEquals("Pending", $purchaseOrder->getStatus());
        $this->assertCount(1, $purchaseOrder->getLineItems());
        $this->assertEquals("Widget A", $purchaseOrder->getLineItems()[0]->getTitle());
    }
}
