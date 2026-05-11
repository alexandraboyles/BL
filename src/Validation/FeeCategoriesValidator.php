<?php
namespace App\Validation;

class FeeCategoriesValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Applies To validation
        $appliesTo = trim($data['appliesTo'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$appliesTo)) {
            $errors[] = "Invalid input. Applies To can only contain letters.";
        }

        // Account validation
        $account = trim($data['account'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$account)) {
            $errors[] = "Invalid input. Account can only contain letters.";
        }

        // Fee Category validation
        $feeCategory_name = trim($data['feeCategory_name'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$feeCategory_name)) {
            $errors[] = "Invalid input. Fee Category can only contain letters.";
        }


        // Counts Toward Minimum Charges validation
        $counts_toward_minimum_charges = trim($data['counts_toward_minimum_charges'] ?? '');
        if (!in_array($counts_toward_minimum_charges, ['0', '1'], true)) {
            $errors[] = "Invalid input. Counts Toward Minimum Charges must be Yes or No.";
        }

        // Name Editable validation
        $is_name_editable = trim($data['is_name_editable'] ?? '');
        if (!in_array($is_name_editable, ['0', '1'], true)) {
            $errors[] = "Invalid input. Name Editable must be Yes or No.";
        }
        return $errors;
    }
}
