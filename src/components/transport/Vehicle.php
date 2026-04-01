<?php
namespace Transport;

use Core\BaseModel;

class Vehicle extends BaseModel {
    public string $name;
    public string $status;

    public function __construct($name, $status) {
        parent::__construct();
        $this->name = $name;
        $this->status = $status;
    }
}
