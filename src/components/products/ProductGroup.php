<?php
namespace Products;

use Core\BaseModel;

class ProductGroup extends BaseModel {
    private $customerId;
    private int $productTypeId;
    private string $name;
    private string $description;

    public function __construct($customerId, $productTypeId, $name, $description) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->productTypeId = $productTypeId;
        $this->name = $name;
        $this->description = $description;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getProductTypeId(): int {
        return $this->productTypeId;
    }

    public function setProductTypeId(int $productTypeId): void {
        $this->productTypeId = $productTypeId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
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

