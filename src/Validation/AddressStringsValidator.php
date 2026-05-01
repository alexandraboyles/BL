<?php
namespace App\Validation;

class AddressStringsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Text validation
        $text = trim($data['text'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\s.,\-\/&?()\'"]+$/', $text)) {
            $errors[] = "Invalid input. Text contains restricted characters.";
        }
        return $errors;
        
    }
}
