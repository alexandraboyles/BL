<?php
namespace App\Validation;

class AddressDefaultInstructionsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Address ID validation
        $address_id = trim($data['address_id'] ?? '');
        if (!is_numeric($address_id) || (int)$address_id <= 0) {
            $errors[] = "Address ID should be a positive number";
        }

        // Instruction text validation
        $instruction_text = trim($data['instruction_text'] ?? '');
        if (empty($instruction_text)) {
            $errors[] = "Instruction text is required";
        }

        return $errors;
    }
}
