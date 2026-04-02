<?php
namespace Transport;

use Core\BaseModel;

class Vehicle extends BaseModel {
    private string $name;
    private string $status;

    public function __construct($name, $status) {
        parent::__construct();
        $this->name = $name;
        $this->status = $status;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

