<?php
namespace Core;

class RuntimeException extends \RuntimeException {
    protected $context;

    public function __construct($message, $context = null, $code = 0, ?\Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    public function getContext() {
        return $this->context;
    }
}
