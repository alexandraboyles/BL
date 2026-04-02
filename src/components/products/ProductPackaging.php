<?php
namespace Products;

use Core\BaseModel;

class ProductPackaging extends BaseModel {
    private $customerId;
    private $productId;
    private int $productTypeId;
    private string $basicUnitOfMeasure;
    private $dateCreated;
    private $lastModified;
    private string $description;

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

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId): void {
        $this->productId = $productId;
    }

    public function getProductTypeId(): int {
        return $this->productTypeId;
    }

    public function setProductTypeId(int $productTypeId): void {
        $this->productTypeId = $productTypeId;
    }

    public function getBasicUnitOfMeasure(): string {
        return $this->basicUnitOfMeasure;
    }

    public function setBasicUnitOfMeasure(string $basicUnitOfMeasure): void {
        $this->basicUnitOfMeasure = $basicUnitOfMeasure;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated): void {
        $this->dateCreated = $dateCreated;
    }

    public function getLastModified() {
        return $this->lastModified;
    }

    public function setLastModified($lastModified): void {
        $this->lastModified = $lastModified;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

