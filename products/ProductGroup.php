<?php
namespace Products;

use Core\BaseModel;

class ProductGroup extends BaseModel {
    public $customerId;
    public $productTypeId;
    public $name;
    public $description;

    public function __construct($customerId, $productTypeId, $name, $description) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->productTypeId = $productTypeId;
        $this->name = $name;
        $this->description = $description;
    }
}
