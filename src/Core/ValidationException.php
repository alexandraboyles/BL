<?php
namespace Core;

class ValidationException extends \InvalidArgumentException {
    protected $field;

    public function __construct($message, $field = null, $code = 0, ?\Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->field = $field;
    }

    public function getField() {
        return $this->field;
    }
}
