<?php
namespace WarehouseSettings;

use Core\BaseModel;

class SaleOrderPriorityStatus extends BaseModel {
    public $name;
    public $priority;
    public $description;

    public function __construct($name, $priority, $description) {
        parent::__construct();
        $this->name = $name;
        $this->priority = $priority;
        $this->description = $description;
    }
}
