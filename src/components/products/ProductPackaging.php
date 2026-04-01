<?php
namespace Products;

use Core\BaseModel;

class ProductPackaging extends BaseModel {
    public $customerId;
    public $productId;
    public int $productTypeId;
    public string $basicUnitOfMeasure;
    public $dateCreated;
    public $lastModified;
    public string $description;

    public function __construct($customerId, $productId, $productTypeId, $basicUnitOfMeasure, $dateCreated, $lastModified, $description) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->productTypeId = $productTypeId;
        $this->basicUnitOfMeasure = $basicUnitOfMeasure;
        $this->dateCreated = date('Y-m-d H:i:s');
        $this->lastModified = date('Y-m-d H:i:s');
        $this->description = $description;
    }
}
