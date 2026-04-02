<?php
namespace WarehouseSettings;

use Core\BaseModel;

class WarehouseLocation extends BaseModel {
    private int $productTypeId;
    private string $name;
    private string $barcode;
    private string $zone;
    private string $type;
    private string $capacity;
    private string $pick_replenishEfficiency;
    private bool $is_active;
    private string $chargeGroup;
    private $created;
    private $modified;

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

    public function getProductTypeId(): int {
        return $this->productTypeId;
    }

    public function setProductTypeId(int $productTypeId): void {
        $this->productTypeId = $productTypeId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getBarcode(): string {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): void {
        $this->barcode = $barcode;
    }

    public function getZone(): string {
        return $this->zone;
    }

    public function setZone(string $zone): void {
        $this->zone = $zone;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function getCapacity(): string {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): void {
        $this->capacity = $capacity;
    }

    public function getPick_replenishEfficiency(): string {
        return $this->pick_replenishEfficiency;
    }
    
    public function getPickReplenishEfficiency(): string {
        return $this->pick_replenishEfficiency;
    }

    public function setPick_replenishEfficiency(string $pick_replenishEfficiency): void {
        $this->pick_replenishEfficiency = $pick_replenishEfficiency;
    }

    public function getIs_active(): bool {
        return $this->is_active;
    }
    
    public function getIsActive(): bool {
        return $this->is_active;
    }

    public function setIs_active(bool $is_active): void {
        $this->is_active = $is_active;
    }

    public function getChargeGroup(): string {
        return $this->chargeGroup;
    }

    public function setChargeGroup(string $chargeGroup): void {
        $this->chargeGroup = $chargeGroup;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created): void {
        $this->created = $created;
    }

    public function getModified() {
        return $this->modified;
    }

    public function setModified($modified): void {
        $this->modified = $modified;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

