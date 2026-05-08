<?php
namespace App\Validation;

class CustomersValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Name validation
        $name = trim($data['customer_name'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$name)) {
            $errors[] = "Invalid input. Name can only contain letters.";
        }

        // Phone validation - Allow digits, spaces, +, (, ), and -
        $phone = trim($data['contact_phone'] ?? '');
        if (!preg_match('/^[0-9+\s()\-]+$/', $phone)) {
            $errors[] = "Invalid input. Phone can only contain digits, spaces, and +, -, (, ) symbols.";
        }

        // Email validation - Use filter_var for better validation
        $email = trim($data['contact_email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid input. Please enter a valid email address.";
        }
        return $errors;
    }
}
