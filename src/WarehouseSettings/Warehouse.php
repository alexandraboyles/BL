<?php
namespace WarehouseSettings;

use Core\BaseModel;

class Warehouse extends BaseModel {
    public $addressId;
    public $deliveryRunId;
    public $name;

    public function __construct($addressId, $deliveryRunId, $name) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->deliveryRunId = $deliveryRunId;
        $this->name = $name;
    }
}
