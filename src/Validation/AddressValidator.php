<?php
namespace App\Validation;

class AddressValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Address ID validation
        $address_id = trim($data['address_id'] ?? '');
        if (!is_numeric($address_id) || (int)$address_id <= 0) {
            $errors[] = "Address ID should be a positive number.";
        }

        // Name validation
        $name = trim($data['address_name'] ?? '');
        if (!preg_match('/^[A-Za-z0-9 ]+$/', $name)) {
            $errors[] = "Invalid input. Name can only contain letters and numbers.";
        }

        // Street 1 validation
        $street_1 = trim($data['street_1'] ?? '');
        if (!preg_match('/^[A-Za-z0-9 ]+$/', $street_1)) {
            $errors[] = "Invalid input. Street 1 can only contain letters and numbers.";
        }

        // Street 2 validation
        $street_2 = trim($data['street_2'] ?? '');
        if (!preg_match('/^[A-Za-z0-9 ]+$/', $street_2)) {
            $errors[] = "Invalid input. Street 2 can only contain letters and numbers.";
        }

        // Suburb validation
        $suburb = trim($data['suburb'] ?? '');
        if (!ctype_alpha($suburb)) {
            $errors[] = "Suburb can only contain letters.";
        }

        // State validation
        $state = trim($data['state'] ?? '');
        if (!ctype_alpha($state)) {
            $errors[] = "State can only contain letters.";
        }

        // Postcode validation
        $postcode = trim($data['postcode'] ?? '');
        if (strlen($postcode) != 4) {
            $errors[] = "Postcode must be 4 digits only.";
        }
        return $errors;
        
    }
}
