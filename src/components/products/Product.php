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

    public function getProductId(): int {
        return $this->productId;
    }

    public function setProductId(int $productId): void {
        $this->productId = $productId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getSku() {
        return $this->sku;
    }

    public function setSku($sku): void {
        $this->sku = $sku;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function setOrderDate($orderDate): void {
        $this->orderDate = $orderDate;
    }

    public function getUnitOfMeasure(): string {
        return $this->unitOfMeasure;
    }

    public function setUnitOfMeasure(string $unitOfMeasure): void {
        $this->unitOfMeasure = $unitOfMeasure;
    }

    public function getWidth(): float {
        return $this->width;
    }

    public function setWidth(float $width): void {
        $this->width = $width;
    }

    public function getLength(): float {
        return $this->length;
    }

    public function setLength(float $length): void {
        $this->length = $length;
    }

    public function getHeight(): float {
        return $this->height;
    }

    public function setHeight(float $height): void {
        $this->height = $height;
    }

    public function getWeight(): float {
        return $this->weight;
    }

    public function setWeight(float $weight): void {
        $this->weight = $weight;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

