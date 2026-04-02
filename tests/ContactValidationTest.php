<?php
use PHPUnit\Framework\TestCase;
use Contacts\Contact;
use Core\ValidationException;

class ContactValidationTest extends TestCase {
    public function testInvalidEmailThrowsValidationException() {
        $this->expectException(ValidationException::class);
        new Contact(1, "Alice Smith", 123, "0400123456"); //numeric email
    }
}