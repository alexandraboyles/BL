<?php
use PHPUnit\Framework\TestCase;
use Products\Product;
use Core\ValidationException;

class ProductValidationTest extends TestCase {
    public function testInvalidWeightThrowsValidationException() {
        $this->expectException(ValidationException::class);
        new Product(501, 1, "Widget A", "High quality widget", "SKU-12345", "2026-03-15", "Box", 10.0, 5.0, 3.0, -2.5);
    }

    public function testEmptyTitleThrowsValidationException() {
        $this->expectException(ValidationException::class);
        new Product(502, 1, "", "Missing title", "SKU-67890", "2026-03-16", "Box", 10.0, 5.0, 3.0, 2.5);
    }
}
