<?php
use PHPUnit\Framework\TestCase;
use Addresses\Address;

class BaseModelTest extends TestCase {
    public function testToArrayAndToString() {
        $address = new Address(1, "123 Main St", "Unit 4", "Brisbane", "QLD", "4000");

        $array = $address->toArray();
        $this->assertArrayHasKey('street_1', $array);
        $this->assertEquals("123 Main St", $array['street_1']);

        $string = (string)$address;
        $this->assertStringContainsString("123 Main St", $string);
    }
}
