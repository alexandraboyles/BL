<?php
namespace WarehouseSettings;

use Core\BaseModel;

class SaleOrderPriorityStatus extends BaseModel {
    public string $name;
    public int $priority;
    public string $description;

    public function __construct($name, $priority, $description) {
        parent::__construct();
        $this->name = $name;
        $this->priority = $priority;
        $this->description = $description;
    }
}
