<?php
namespace Addresses;

use Core\BaseModel;

class AddressString extends BaseModel {
    private $customerId;
    private $addressId;
    private string $text;

    public function __construct($customerId, $addressId, $text) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->addressId = $addressId;
        $this->text = $text;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getAddressId() {
        return $this->addressId;
    }

    public function setAddressId($addressId): void {
        $this->addressId = $addressId;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setText(string $text): void {
        $this->text = $text;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

