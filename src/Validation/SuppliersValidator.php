<?php
namespace App\Validation;

class SuppliersValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Company Name validation - Allow letters, numbers, spaces, and common symbols
        $companyName = trim($data['companyName'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\s.,\-\/&?()\'"]+$/', $companyName)) {
            $errors[] = "Invalid input. Company Name contains restricted characters.";
        }

        // Email validation - Use filter_var for better validation
        $email = trim($data['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid input. Please enter a valid email address.";
        }

        // Telephone Number validation - Allow digits, spaces, +, (, ), and -
        $telNo = trim($data['telNo'] ?? '');
        if (!preg_match('/^[0-9+\s()\-]+$/', $telNo)) {
            $errors[] = "Invalid input. Telephone Number can only contain digits, spaces, and +, -, (, ) symbols.";
        }

        // Accounting Connector validation - Allow letters, numbers and spaces
        $accountingConnector = trim($data['accountingConnector'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\s]+$/', $accountingConnector)) {
            $errors[] = "Accounting Connector can only contain letters, numbers and spaces.";
        }
        return $errors;
    }
}
