<?php
namespace Misc;

use Core\BaseModel;

class ConsignmentErrorChargeAction extends BaseModel {
    private string $name;
    private string $errorCause;

    public function __construct($name, $errorCause) {
        parent::__construct();
        $this->name = $name;
        $this->errorCause = $errorCause;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getErrorCause(): string {
        return $this->errorCause;
    }

    public function setErrorCause(string $errorCause): void {
        $this->errorCause = $errorCause;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

