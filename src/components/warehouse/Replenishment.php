<?php
namespace Warehouse;

use Core\BaseModel;

class Replenishment extends BaseModel {
    public $customerId;
    public $productId;
    public $locationId;
    public $stocktakesId;
    public $name;
    public $plannedDate;

    public function __construct($customerId, $productId, $locationId, $stocktakesId, $name, $plannedDate) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->locationId = $locationId;
        $this->stocktakesId = $stocktakesId;
        $this->name = $name;
        $this->plannedDate = $plannedDate;
    }
}
