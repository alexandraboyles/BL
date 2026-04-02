<?php
namespace Products;

use Core\BaseModel;

class ProductStatus extends BaseModel {
    private string $name;
    private bool $charge_storage;
    private bool $status_in_use;

    public function __construct($name, $charge_storage, $status_in_use) {
        parent::__construct();
        $this->name = $name;
        $this->charge_storage = $charge_storage;
        $this->status_in_use = $status_in_use;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getChargeStorage(): bool {
        return $this->charge_storage;
    }

    public function setCharge_storage(bool $charge_storage): void {
        $this->charge_storage = $charge_storage;
    }

    public function getStatusInUse(): bool {
        return $this->status_in_use;
    }

    public function setStatus_in_use(bool $status_in_use): void {
        $this->status_in_use = $status_in_use;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

