<?php
namespace Core;

class Validator {
    public static function positiveNumber($value, $fieldName) {
        if ($value <= 0) {
            throw new ValidationException("$fieldName must be greater than zero", $fieldName);
        }
        return $value;
    }

    public static function nonNegativeNumber($value, $fieldName) {
        if ($value < 0) {
            throw new ValidationException("$fieldName must be non-negative", $fieldName);
        }
        return $value;
    }

    public static function validDateRange($startDate, $endDate) {
        if (strtotime($endDate) < strtotime($startDate)) {
            throw new ValidationException("End date cannot be before start date", "endDate");
        }
        return [$startDate, $endDate];
    }

    public static function notEmpty($value, $fieldName) {
        if (empty($value)) {
            throw new ValidationException("$fieldName cannot be empty", $fieldName);
        }
        return $value;
    }
}
