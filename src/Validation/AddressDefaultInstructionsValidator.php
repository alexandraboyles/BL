<?php
namespace App\Validation;

class AddressDefaultInstructionsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Delivery Instruction validation
        $deliveryInstruction = trim($data['deliveryInstruction'] ?? '');
        if (!preg_match('/^[A-Za-z0-9 ]+$/', $deliveryInstruction)) {
            $errors[] = "Invalid input. Delivery Instruction can only contain letters and numbers.";
        }

        // Packing Instruction validation
        $packingInstruction = trim($data['packingInstruction'] ?? '');
        if (!preg_match('/^[A-Za-z0-9 ]+$/', $packingInstruction)) {
            $errors[] = "Invalid input. Packing Instruction can only contain letters and numbers.";
        }
        return $errors;
        
    }
}
