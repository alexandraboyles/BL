<?php
namespace Addresses;

use Core\BaseModel;

class DeliveryAddressToOnforwarderAddressMapping extends BaseModel {
    public $addressId;
    public $customerId;
    public $productId;

    public function __construct($addressId, $customerId, $productId) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->productId = $productId;
    }
}
