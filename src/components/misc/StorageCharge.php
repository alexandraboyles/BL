<?php
namespace Misc;

use Core\BaseModel;

class StorageCharge extends BaseModel {
    public string $name;
    public float $amount;

    public function __construct($name, $amount) {
        parent::__construct();
        $this->name = $name;
        $this->amount = $amount;
    }
}
