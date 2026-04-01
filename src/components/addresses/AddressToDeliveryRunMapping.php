<?php
namespace Addresses;

use Core\BaseModel;

class AddressToDeliveryRunMapping extends BaseModel {
    public int $addressId;
    public $customerId;
    public $productId;
    public $deliveryRunId;
    public int $carrierId;
    public string $flowDirection;

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
