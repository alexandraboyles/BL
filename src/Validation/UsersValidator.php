<?php
namespace App\Validation;

class UsersValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Full Name validation
        $fullName = trim($data['fullName'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$fullName)) {
            $errors[] = "Invalid input. Full Name can only contain letters.";
        }

        // Email validation - Use filter_var for better validation
        $email = trim($data['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid input. Please enter a valid email address.";
        }

        // MFA validation
        $mfa = trim($data['mfa'] ?? '');
        if (!preg_match('/^[A-Za-z \-_]+$/', $mfa)) {
            $errors[] = "Invalid input. MFA can only contain letters and restricted characters.";
        }
        
        // Roles validation (should be array of role IDs)
        $rolesId = $data['roles_id'] ?? [];
        if (!is_array($rolesId) || empty($rolesId)) {
            $errors[] = "Invalid input. Please select at least one role.";
        } else {
            foreach ($rolesId as $roleId) {
                if (!is_numeric($roleId) || $roleId <= 0) {
                    $errors[] = "Invalid input. Invalid role selection.";
                    break;
                }
            }
        }

        // Warehouses ID validation
        $warehousesId = trim($data['warehouses_id'] ?? '');
        if (!is_numeric($warehousesId) || $warehousesId <= 0) {
            $errors[] = "Invalid input. Please select a warehouse.";
        }

        // Customer ID validation
        $customerId = trim($data['customer_id'] ?? '');
        if ($customerId === '') {
            $errors[] = "Invalid input. Please select a customer.";
        }

        // Email Verified validation
        $is_email_verified = trim($data['is_email_verified'] ?? '');
        if (!in_array($is_email_verified, ['0', '1'], true)) {
            $errors[] = "Invalid input. Email Verified must be Yes or No.";
        }
        return $errors;
    }
}
