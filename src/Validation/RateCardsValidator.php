<?php
namespace App\Validation;

class RateCardsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Rates validation
        $rates = trim($data['rates'] ?? '');
        if (!preg_match('/^[A-Za-z0-9 ]+$/', $rates)) {
            $errors[] = "Invalid input. Rates can only contain letters and numbers.";
        }

        // Contact Email validation - Use filter_var for better validation
        $contact_email = trim($data['contact_email'] ?? '');
        if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid input. Please enter a valid email address.";
        }

        return $errors;
    }
}
