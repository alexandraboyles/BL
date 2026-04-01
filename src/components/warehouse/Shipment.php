<?php
namespace Warehouse;

use Core\BaseModel;

class Shipment extends BaseModel {
    public string $status;
    public int $numOfContainers;
    public int $numOfPOs;

    public function __construct($status, $numOfContainers, $numOfPOs) {
        parent::__construct();
        $this->status = $status;
        $this->numOfContainers = $numOfContainers;
        $this->numOfPOs = $numOfPOs;
    }
}
