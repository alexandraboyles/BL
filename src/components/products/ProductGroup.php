<?php
namespace Products;

use Core\BaseModel;

class ProductGroup extends BaseModel {
    public $customerId;
    public int $productTypeId;
    public string $name;
    public string $description;

    public function __construct($customerId, $productTypeId, $name, $description) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->productTypeId = $productTypeId;
        $this->name = $name;
        $this->description = $description;
    }
}
