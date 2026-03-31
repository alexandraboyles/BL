<?php
namespace Transport;

use Core\BaseModel;

class DeliveryRun extends BaseModel {
    public $name;
    public $carrier;

    public function __construct($name, $carrier) {
        parent::__construct();
        $this->name = $name;
        $this->carrier = $carrier;
    }
}