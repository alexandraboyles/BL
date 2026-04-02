<?php
use PHPUnit\Framework\TestCase;
use Transport\Consignment;

class ConsignmentTest extends TestCase {
    public function testConsignmentCreation() {
        $consignment = new Consignment(
            301, 101, 1, 501, 401, 201, 601,
            "Express", "REF-789", true, 10, 2.5, 25.0, 2, 5
        );

        $this->assertEquals(301, $consignment->getConsignmentId());
        $this->assertEquals("Express", $consignment->getService());
        $this->assertTrue($consignment->getIsResidential());
        $this->assertEquals(10, $consignment->getQuantity());
    }
}
