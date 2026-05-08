<?php
namespace App\Validation;

class ContactsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Contact Name validation
        $contactName = trim($data['contact_name'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$contactName)) {
            $errors[] = "Invalid input. Contact Name can only contain letters.";
        }

        // Email validation - Use filter_var for better validation
        $email = trim($data['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid input. Please enter a valid email address.";
        }

        // Phone validation - Allow digits, spaces, +, (, ), and -
        $phone = trim($data['phone'] ?? '');
        if (!preg_match('/^[0-9+\s()\-]+$/', $phone)) {
            $errors[] = "Invalid input. Phone can only contain digits, spaces, and +, -, (, ) symbols.";
        }

        return $errors;
    }
}
