<?php
namespace Addresses;

use Core\BaseModel;

class AddressToDeliveryRunMapping extends BaseModel {
    public int $id;
    public string $addressId;
    public string $customerId;
    public string $productId;
    public string $deliveryRunId;
    public int $carrierId;
    public string $flowDirection;

    public function __construct($id, $addressId, $customerId, $productId, $deliveryRunId, $carrierId, $flowDirection) {
        parent::__construct();
        $this->id = $id;
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->deliveryRunId = $deliveryRunId;
        $this->carrierId = $carrierId;
        $this->flowDirection = $flowDirection;
    }
}
