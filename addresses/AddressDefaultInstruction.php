<?php
namespace Addresses;

use Core\BaseModel;

class AddressDefaultInstruction extends BaseModel {
    public string $addressId;
    public string $customerId;
    public string $deliveryInstruction;
    public string $packingInstruction;

    public function __construct($addressId, $customerId, $deliveryInstruction, $packingInstruction) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->deliveryInstruction = $deliveryInstruction;
        $this->packingInstruction = $packingInstruction;
    }
}
