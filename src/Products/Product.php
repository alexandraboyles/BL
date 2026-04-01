<?php
namespace Products;

use Core\BaseModel;
use Core\Validator;

class Product extends BaseModel {
    private int $productId;
    private $customerId;
    private string $title;
    private string $description;
    private $sku;
    private $orderDate;
    private string $unitOfMeasure;
    private float $width;
    private float $length;
    private float $height;
    private float $weight;

    public function __construct($productId, $customerId, $title, $description, $sku, $orderDate, $unitOfMeasure, $width, $length, $height, $weight) {
        parent::__construct();

        $this->weight = Validator::positiveNumber($weight, "Weight");
        $this->width  = Validator::positiveNumber($width, "Width");
        $this->length = Validator::positiveNumber($length, "Length");
        $this->height = Validator::positiveNumber($height, "Height");

        $this->productId = $productId;
        $this->customerId = $customerId;
        $this->title = Validator::notEmpty($title, "Title");
        $this->description = Validator::isString($description, "Description");
        $this->sku = Validator::notEmpty($sku, "SKU");
        $this->orderDate = date('Y-m-d H:i:s');
        $this->unitOfMeasure = Validator::isString($unitOfMeasure, "Unit of Measure");
    }
}
