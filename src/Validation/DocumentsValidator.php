<?php
namespace App\Validation;

class DocumentsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // File Type validation
        $fileType = trim($data['fileType'] ?? '');
        if (!ctype_alpha($fileType)) {
            $errors[] = "Invalid input. File Type can only contain letters.";
        }
        return $errors;
    }
}
