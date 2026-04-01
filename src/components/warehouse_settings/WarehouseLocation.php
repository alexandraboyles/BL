<?php
namespace WarehouseSettings;

use Core\BaseModel;

class WarehouseLocation extends BaseModel {
    public int $productTypeId;
    public string $name;
    public string $barcode;
    public string $zone;
    public string $type;
    public string $capacity;
    public string $pick_replenishEfficiency;
    public bool $is_active;
    public string $chargeGroup;
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
        $this->created = date('Y-m-d H:i:s');
        $this->modified = date('Y-m-d H:i:s');
    }
}
