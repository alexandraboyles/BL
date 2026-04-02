<?php
namespace TransportSettings;

use Core\BaseModel;

class BankingSheet extends BaseModel {
    private $customerId;
    private $dateAdded;
    private string $status;
    private string $value;

    public function __construct($customerId, $dateAdded, $status, $value) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->dateAdded = date('Y-m-d H:i:s');
        $this->status = $status;
        $this->value = $value;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function setDateAdded($dateAdded): void {
        $this->dateAdded = $dateAdded;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getValue(): string {
        return $this->value;
    }

    public function setValue(string $value): void {
        $this->value = $value;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

