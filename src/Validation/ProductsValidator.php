<?php
namespace App\Validation;

class ProductsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Title validation
        $title = trim($data['title'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$title)) {
            $errors[] = "Invalid input. Title can only contain letters.";
        }

        // Description validation
        $description = trim($data['description'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\s.,\-\/&?()\'"]+$/', $description)) {
            $errors[] = "Invalid input. Description contains restricted characters.";
        }

        // SKU validation
        $sku = trim($data['sku'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\-]+$/',$sku)) {
            $errors[] = "Invalid input. SKU can only contain letters.";
        }

        // Unit of Measure validation
        $unitOfMeasure = trim($data['unitOfMeasure'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$unitOfMeasure)) {
            $errors[] = "Invalid input. Unit of Measure can only contain letters.";
        }

        // Width validation
        $width = trim($data['width'] ?? '');
        if (!is_numeric($width) || (int)$width <= 0) {
            $errors[] = "Width must be a number or whole number.";
        }

        // Length validation
        $length = trim($data['length'] ?? '');
        if (!is_numeric($length) || (int)$length <= 0) {
            $errors[] = "Length must be a number or whole number.";
        }

        // Height validation
        $height = trim($data['height'] ?? '');
        if (!is_numeric($height) || (int)$height <= 0) {
            $errors[] = "Height must be a number or whole number.";
        }

        // Weight validation
        $weight = trim($data['weight'] ?? '');
        if (!is_numeric($weight) || (int)$weight <= 0) {
            $errors[] = "Weight must be a number or whole number.";
        }

        return $errors;
    }
}
