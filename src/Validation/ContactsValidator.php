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

        // Email validation
        $email = trim($data['email'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\-_.@]+$/', $email)) {
            $errors[] = "Invalid input. Email contains restricted characters.";
        }

        // Phone validation
        $phone = trim($data['phone'] ?? '');
        if (!preg_match('/^[z0-9]+$/', $phone)) {
            $errors[] = "Invalid input. Phone can only contain numbers.";
        }
        return $errors;
    }
}
