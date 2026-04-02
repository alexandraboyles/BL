<?php
use PHPUnit\Framework\TestCase;
use Addresses\Address;
use Core\ValidationException;

class AddressValidationTest extends TestCase {
    public function testInvalidStateThrowsValidationException() {
        $this->expectException(ValidationException::class);
        new Address(1, "123 Main St", "Unit 4", "Brisbane", 1, "4000"); //numeric state
    }
}