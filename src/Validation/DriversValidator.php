<?php
namespace App\Validation;

class DriversValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Driver Name validation
        $driver_name = trim($data['driver_name'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$driver_name)) {
            $errors[] = "Invalid input. Driver Name can only contain letters.";
        }

        // Email validation - Use filter_var for better validation
        $email = trim($data['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid input. Please enter a valid email address.";
        }

        // Is Online validation
        $is_online = trim($data['is_online'] ?? '');
        if (!in_array($is_online, ['0', '1'], true)) {
            $errors[] = "Invalid input. Is Online must be Yes or No.";
        }

        // Location Access Available validation
        $location_access_available = trim($data['location_access_available'] ?? '');
        if (!in_array($location_access_available, ['0', '1'], true)) {
            $errors[] = "Invalid input. Location Access Available must be Yes or No.";
        }
        return $errors;
    }
}
