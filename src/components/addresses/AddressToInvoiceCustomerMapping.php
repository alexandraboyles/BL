<?php
namespace Addresses;

use Core\BaseModel;

class AddressToInvoiceCustomerMapping extends BaseModel {
    private $customerId;
    private $addressId;

    public function __construct($customerId, $addressId) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->addressId = $addressId;
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

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

