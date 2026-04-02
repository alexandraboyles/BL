<?php
namespace Addresses;

use Core\BaseModel;

class AddressDefaultInstruction extends BaseModel {
    private $addressId;
    private $customerId;
    private string $deliveryInstruction;
    private string $packingInstruction;

    public function __construct($addressId, $customerId, $deliveryInstruction, $packingInstruction) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->deliveryInstruction = $deliveryInstruction;
        $this->packingInstruction = $packingInstruction;
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

    public function getDeliveryInstruction(): string {
        return $this->deliveryInstruction;
    }

    public function setDeliveryInstruction(string $deliveryInstruction): void {
        $this->deliveryInstruction = $deliveryInstruction;
    }

    public function getPackingInstruction(): string {
        return $this->packingInstruction;
    }

    public function setPackingInstruction(string $packingInstruction): void {
        $this->packingInstruction = $packingInstruction;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

