<?php
namespace App\Validation;

class AccountsValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Account Name validation
        $account_name = trim($data['account_name'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$account_name)) {
            $errors[] = "Invalid input. Account Name can only contain letters.";
        }

        // Description validation
        $description = trim($data['description'] ?? '');
        if (!preg_match('/^[A-Za-z0-9\s.,\-\/&?()\'"]+$/', $description)) {
            $errors[] = "Invalid input. Description contains restricted characters.";
        }

        // Display When No Value validation
        $display_when_no_value = trim($data['display_when_no_value'] ?? '');
        if (!in_array($display_when_no_value, ['0', '1'], true)) {
            $errors[] = "Invalid input. Display When No Value must be Yes or No.";
        }
        return $errors;
    }
}
