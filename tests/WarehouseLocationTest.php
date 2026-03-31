<?php
use PHPUnit\Framework\TestCase;
use WarehouseSettings\WarehouseLocation;

class WarehouseLocationTest extends TestCase {
    public function testWarehouseLocationCreation() {
        $location = new WarehouseLocation(
            1, "Zone A - Shelf 1", "BARCODE-001", "Zone A", "Shelf",
            100, 95, true, "ChargeGroupA", "2026-03-01", "2026-03-31"
        );

        $this->assertEquals("Zone A - Shelf 1", $location->name);
        $this->assertTrue($location->is_active);
        $this->assertEquals("Shelf", $location->type);
        $this->assertEquals(100, $location->capacity);
    }
}
