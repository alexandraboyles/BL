<?php
namespace Transport;

use Core\BaseModel;

class Vehicle extends BaseModel {
    public $name;
    public $status;

    public function __construct($name, $status) {
        parent::__construct();
        $this->name = $name;
        $this->status = $status;
    }
}
