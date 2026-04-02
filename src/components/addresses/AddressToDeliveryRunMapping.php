<?php
namespace Addresses;

use Core\BaseModel;

class AddressToDeliveryRunMapping extends BaseModel {
    private int $addressId;
    private $customerId;
    private $productId;
    private $deliveryRunId;
    private int $carrierId;
    private string $flowDirection;

    public function __construct($addressId, $customerId, $productId, $deliveryRunId, $carrierId, $flowDirection) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->deliveryRunId = $deliveryRunId;
        $this->carrierId = $carrierId;
        $this->flowDirection = $flowDirection;
    }

    public function getAddressId(): int {
        return $this->addressId;
    }

    public function setAddressId(int $addressId): void {
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

    public function getDeliveryRunId() {
        return $this->deliveryRunId;
    }

    public function setDeliveryRunId($deliveryRunId): void {
        $this->deliveryRunId = $deliveryRunId;
    }

    public function getCarrierId(): int {
        return $this->carrierId;
    }

    public function setCarrierId(int $carrierId): void {
        $this->carrierId = $carrierId;
    }

    public function getFlowDirection(): string {
        return $this->flowDirection;
    }

    public function setFlowDirection(string $flowDirection): void {
        $this->flowDirection = $flowDirection;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

