<?php
namespace Transport;

use Core\BaseModel;

class DeliveryRun extends BaseModel {
    public string $name;
    public string $carrier;

    public function __construct($name, $carrier) {
        parent::__construct();
        $this->name = $name;
        $this->carrier = $carrier;
    }
}