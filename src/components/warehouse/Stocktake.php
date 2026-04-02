<?php
namespace Warehouse;

use Core\BaseModel;

class Stocktake extends BaseModel {
    private $customerId;
    private $productId;
    private $locationId;
    private string $name;
    private $plannedDate;
    private string $status;

    public function __construct($customerId, $productId, $locationId, $name, $plannedDate, $status) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->locationId = $locationId;
        $this->name = $name;
        $this->plannedDate = $plannedDate;
        $this->status = $status;
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

    public function getLocationId() {
        return $this->locationId;
    }

    public function setLocationId($locationId): void {
        $this->locationId = $locationId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getPlannedDate() {
        return $this->plannedDate;
    }

    public function setPlannedDate($plannedDate): void {
        $this->plannedDate = $plannedDate;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

