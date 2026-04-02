<?php
namespace Addresses;

use Core\BaseModel;

class DeliveryAddressToOnforwarderAddressMapping extends BaseModel {
    private $addressId;
    private $customerId;
    private $productId;

    public function __construct($addressId, $customerId, $productId) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->productId = $productId;
    }

    public function getAddressId() {
        return $this->addressId;
    }

    public function setAddressId($addressId): void {
        $this->addressId = $addressId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId): void {
        $this->productId = $productId;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

