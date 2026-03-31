<?php
namespace Addresses;

use Core\BaseModel;

class DeliveryAddressToOnforwarderAddressMapping extends BaseModel {
    public int $id;
    public string $addressId;
    public string $customerId;
    public string $productId;

    public function __construct($id, $addressId, $customerId, $productId) {
        parent::__construct();
        $this->id = $id;
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->productId = $productId;
    }
}
