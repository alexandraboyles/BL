<?php
namespace App\Validation;

class ParsersValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        $stringFields = [
            'parser_name'       => 'Parser Name',
            'className'         => 'Class Name',
            'class'             => 'Class',
            'type'              => 'Type',
            'acceptedFileTypes' => 'Accepted File Types',
            'toAddress'         => 'To Address'
        ];

        foreach ($stringFields as $field => $label) {
            $value = trim($data[$field] ?? '');
            
            // Only check if not empty, following the "remove is required" instruction
            // and checking for letters only if provided.
            if ($value !== '' && !ctype_alpha($value)) {
                $errors[] = "Invalid input. {$label} must contain only letters and no special characters.";
            }
        }

        return $errors;
    }
}
