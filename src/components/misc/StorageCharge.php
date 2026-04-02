<?php
namespace Misc;

use Core\BaseModel;

class StorageCharge extends BaseModel {
    private string $name;
    private float $amount;

    public function __construct($name, $amount) {
        parent::__construct();
        $this->name = $name;
        $this->amount = $amount;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

