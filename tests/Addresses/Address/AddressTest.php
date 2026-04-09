<?php
use PHPUnit\Framework\TestCase;
use Addresses\Address;

class AddressTest extends TestCase {
    public function testAddressCreation() {
        $address = new Address(1, "123 Main St", "Unit 4", "Brisbane", "QLD", "4000");

        $this->assertEquals(1, $address->getAddressId());
        $this->assertEquals("QLD", $address->getState());
        $this->assertEquals("4000", $address->getPostcode());
    }
}
