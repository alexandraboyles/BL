<?php
use PHPUnit\Framework\TestCase;
use Products\Product;

class ProductTest extends TestCase {
    public function testProductCreation() {
        $product = new Product(501, 1, "WidgetA", "High quality widget", "SKU-12345", "", "Box", 10.0, 5.0, 3.0, 2.5);

        $this->assertEquals("WidgetA", $product->getTitle());
        $this->assertEquals("SKU-12345", $product->getSku());
        $this->assertEquals("Box", $product->getUnitOfMeasure());
    }
}
