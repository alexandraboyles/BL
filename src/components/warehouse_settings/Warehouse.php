<?php
namespace WarehouseSettings;

use Core\BaseModel;
use Core\Validator;

class Warehouse extends BaseModel {
    public $addressId;
    public $deliveryRunId;
    public string $name;

    public function __construct($addressId, $deliveryRunId, $name) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->deliveryRunId = $deliveryRunId;
        $this->name = Validator::isString($name, "name");
    }
}
