<?php
namespace WarehouseSettings;

use Core\BaseModel;

class WarehouseLocation extends BaseModel {
    public $productTypeId;
    public $name;
    public $barcode;
    public $zone;
    public $type;
    public $capacity;
    public $pick_replenishEfficiency;
    public $is_active;
    public $chargeGroup;
    public $created;
    public $modified;

    public function __construct($productTypeId, $name, $barcode, $zone, $type, $capacity, $pick_replenishEfficiency, $is_active, $chargeGroup, $created, $modified) {
        parent::__construct();
        $this->productTypeId = $productTypeId;
        $this->name = $name;
        $this->barcode = $barcode;
        $this->zone = $zone;
        $this->type = $type;
        $this->capacity = $capacity;
        $this->pick_replenishEfficiency = $pick_replenishEfficiency;
        $this->is_active = $is_active;
        $this->chargeGroup = $chargeGroup;
        $this->created = $created;
        $this->modified = $modified;
    }
}
