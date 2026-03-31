<?php
namespace Products;

use Core\BaseModel;

class ProductStatus extends BaseModel {
    public $name;
    public $charge_storage;
    public $status_in_use;

    public function __construct($name, $charge_storage, $status_in_use) {
        parent::__construct();
        $this->name = $name;
        $this->charge_storage = $charge_storage;
        $this->status_in_use = $status_in_use;
    }
}
