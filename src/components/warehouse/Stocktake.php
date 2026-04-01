<?php
namespace Warehouse;

use Core\BaseModel;

class Stocktake extends BaseModel {
    public $customerId;
    public $productId;
    public $locationId;
    public string $name;
    public $plannedDate;
    public string $status;

    public function __construct($customerId, $productId, $locationId, $name, $plannedDate, $status) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->locationId = $locationId;
        $this->name = $name;
        $this->plannedDate = $plannedDate;
        $this->status = $status;
    }
}
