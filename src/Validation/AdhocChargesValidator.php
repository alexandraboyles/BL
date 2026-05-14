<?php
namespace App\Validation;

class AdhocChargesValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Adhoc Charge Name validation
        $adhocCharge_name = trim($data['adhocCharge_name'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$adhocCharge_name)) {
            $errors[] = "Invalid input. Adhoc Charge can only contain letters.";
        }

        // Charge Structure validation
        $chargeStructure = trim($data['chargeStructure'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$chargeStructure)) {
            $errors[] = "Invalid input. Charge Structure can only contain letters.";
        }

        // Rate validation
        $rate = trim($data['rate'] ?? '');
        if (!is_numeric($rate) || (int)$rate <= 0) {
            $errors[] = "Rate must be a number or whole number.";
        }

        // Description Template validation
        $descriptionTemplate = trim($data['descriptionTemplate'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$descriptionTemplate)) {
            $errors[] = "Invalid input. Description Template can only contain letters.";
        }

        // Page Vision On validation
        $pageVisionOn = trim($data['pageVisionOn'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$pageVisionOn)) {
            $errors[] = "Invalid input. Page Vision On can only contain letters.";
        }
        return $errors;
    }
}
