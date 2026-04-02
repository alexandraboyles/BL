<?php
namespace WarehouseSettings;

use Core\BaseModel;
use Core\Validator;

class Warehouse extends BaseModel {
    private $addressId;
    private $deliveryRunId;
    private string $name;

    public function __construct($addressId, $deliveryRunId, $name) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->deliveryRunId = $deliveryRunId;
        $this->name = Validator::isString($name, "name");
    }

    public function getAddressId() {
        return $this->addressId;
    }

    public function setAddressId($addressId): void {
        $this->addressId = $addressId;
    }

    public function getDeliveryRunId() {
        return $this->deliveryRunId;
    }

    public function setDeliveryRunId($deliveryRunId): void {
        $this->deliveryRunId = $deliveryRunId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

