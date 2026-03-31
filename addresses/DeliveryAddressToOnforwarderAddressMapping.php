<?php
namespace Addresses;

use Core\BaseModel;

class DeliveryAddressToOnforwarderAddressMapping extends BaseModel {
    public $id;
    public $addressId;
    public $customerId;
    public $productId;

    public function __construct($id, $addressId, $customerId, $productId) {
        parent::__construct();
        $this->id = $id;
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->productId = $productId;
    }
}
