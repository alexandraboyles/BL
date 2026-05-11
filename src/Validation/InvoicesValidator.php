<?php
namespace App\Validation;

class InvoicesValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        // Status validation
        $status = trim($data['status'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$status)) {
            $errors[] = "Invalid input. Status can only contain letters.";
        }

        // Payment Status validation
        $paymentStatus = trim($data['paymentStatus'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$paymentStatus)) {
            $errors[] = "Invalid input. Payment Status can only contain letters.";
        }

        // Email Status validation
        $emailStatus = trim($data['emailStatus'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$emailStatus)) {
            $errors[] = "Invalid input. Email Status can only contain letters.";
        }

        // Internal Reference validation
        $internalReference = trim($data['internalReference'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$internalReference)) {
            $errors[] = "Invalid input. Internal Reference can only contain letters.";
        }

        // External Reference validation
        $externalReference = trim($data['externalReference'] ?? '');
        if (!preg_match('/^[A-Za-z ]+$/',$externalReference)) {
            $errors[] = "Invalid input. External Reference can only contain letters.";
        }

        // Date validation
        $startDate = $data['startDate'] ?? '';
        $endDate = $data['endDate'] ?? '';

        if (!empty($startDate) && !empty($endDate)) {
            if (strtotime($startDate) > strtotime($endDate)) {
                $errors[] = "Start Date cannot be after End Date.";
            }
        }

        return $errors;
    }
}
