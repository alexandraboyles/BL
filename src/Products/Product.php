<?php
namespace Products;

use Core\BaseModel;
use Core\Validator;

class Product extends BaseModel {
    public $productId;
    public $customerId;
    public $title;
    public $description;
    public $sku;
    public $orderDate;
    public $unitOfMeasure;
    public $width;
    public $length;
    public $height;
    public $weight;

    public function __construct($productId, $customerId, $title, $description, $sku, $orderDate, $unitOfMeasure, $width, $length, $height, $weight) {
        parent::__construct();

        $this->weight = Validator::positiveNumber($weight, "Weight");
        $this->width  = Validator::positiveNumber($width, "Width");
        $this->length = Validator::positiveNumber($length, "Length");
        $this->height = Validator::positiveNumber($height, "Height");

        $this->productId = $productId;
        $this->customerId = $customerId;
        $this->title = Validator::notEmpty($title, "Title");
        $this->description = $description;
        $this->sku = Validator::notEmpty($sku, "SKU");
        $this->orderDate = $orderDate;
        $this->unitOfMeasure = $unitOfMeasure;
    }
}
