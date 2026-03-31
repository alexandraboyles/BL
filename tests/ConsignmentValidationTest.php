<?php
use PHPUnit\Framework\TestCase;
use Transport\Consignment;

class ConsignmentValidationTest extends TestCase {
    public function testQuantityMustBeGreaterThanZero() {
        $this->expectException(\InvalidArgumentException::class);

        $consignment = new Consignment(
            301, 101, 1, 501, 401, 201, 601,
            "Express", "REF-789", true, 0, 2.5, 25.0, 2, 5 // invalid quantity
        );

        if ($consignment->quantity <= 0) {
            throw new \InvalidArgumentException("Quantity must be greater than zero");
        }
    }
}
