<?php
namespace App\Validation;

class SurchargesValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Surcharge Name validation
        $surcharge_name = trim($data['surcharge_name'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$surcharge_name)) {
            $errors[] = "Invalid input. Surcharge Name can only contain letters.";
        }

        // Conditions validation
        $conditions = trim($data['conditions'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\s.,\-\/&?()\'"]+$/', $conditions)) {
            $errors[] = "Invalid input. Conditions contains restricted characters.";
        }
        
        // Surcharge validation
        $surcharge = trim($data['surcharge'] ?? '');
        if (!is_numeric($surcharge) || (int)$surcharge <= 0) {
            $errors[] = "Surcharge must be a number or whole number.";
        }

        // Status validation
        $status = trim($data['status'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$status)) {
            $errors[] = "Invalid input. Status can only contain letters.";
        }
        return $errors;
    }
}
