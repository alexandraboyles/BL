<?php
namespace Addresses;

use Core\BaseModel;

class AddressToDeliveryRunMapping extends BaseModel {
    public $addressId;
    public $customerId;
    public $productId;
    public $deliveryRunId;
    public $carrierId;
    public $flowDirection;

    public function __construct($addressId, $customerId, $productId, $deliveryRunId, $carrierId, $flowDirection) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->deliveryRunId = $deliveryRunId;
        $this->carrierId = $carrierId;
        $this->flowDirection = $flowDirection;
    }
}
