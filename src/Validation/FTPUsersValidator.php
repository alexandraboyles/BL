<?php
namespace App\Validation;

class FTPUsersValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // FTP User ID validation
        $ftpUser_id = trim($data['ftpUser_id'] ?? '');
        if (!is_numeric($ftpUser_id) || (int)$ftpUser_id <= 0) {
            $errors[] = "FTP User ID should be a positive number.";
        }

        // Username validation
        $username = trim($data['username'] ?? '');
        if (!preg_match('/^[A-Za-z0-9 ]+$/', $username)) {
            $errors[] = "Invalid input. Username can only contain letters and numbers.";
        }

        // Password validation
        $password = trim($data['password'] ?? '');
        if (!is_string($password)) {
            $errors[] = "Invalid input. Password contains restricted characters.";
        }

        // Subdirectory validation
        $subDirectory = trim($data['subDirectory'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$subDirectory)) {
            $errors[] = "Invalid input. Subdirectory can only contain letters.";
        }
        return $errors;
        
    }
}
