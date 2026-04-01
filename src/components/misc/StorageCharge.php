<?php
namespace Misc;

use Core\BaseModel;

class StorageCharge extends BaseModel {
    public $name;
    public $amount;
    public $status;

    public function __construct($name, $amount, $status) {
        parent::__construct();
        $this->name = $name;
        $this->amount = $amount;
        $this->status = $status;
    }
}
