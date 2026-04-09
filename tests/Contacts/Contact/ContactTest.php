<?php
use PHPUnit\Framework\TestCase;
use Contacts\Contact;

class ContactTest extends TestCase {
    public function testContactCreation() {
        $contact = new Contact(1, "Alice Smith", "alice@example.com", "0400123456");

        $this->assertEquals(1, $contact->getCustomerId());
        $this->assertEquals("0400123456", $contact->getPhone());
    }
}
