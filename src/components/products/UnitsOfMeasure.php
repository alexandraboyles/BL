<?php
namespace Products;

use Core\BaseModel;

class UnitsOfMeasure extends BaseModel {
    private int $productTypeId;
    private string $name;
    private string $code;
    private string $category;
    private bool $oversize_warning;

    public function __construct($productTypeId, $name, $code, $category, $oversize_warning) {
        parent::__construct();
        $this->productTypeId = $productTypeId;
        $this->name = $name;
        $this->code = $code;
        $this->category = $category;
        $this->oversize_warning = $oversize_warning;
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

    public function getCode(): string {
        return $this->code;
    }

    public function setCode(string $code): void {
        $this->code = $code;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function setCategory(string $category): void {
        $this->category = $category;
    }

    public function getOversize_warning(): bool {
        return $this->oversize_warning;
    }

    public function getOversizeWarning(): bool {
        return $this->oversize_warning;
    }

    public function setOversize_warning(bool $oversize_warning): void {
        $this->oversize_warning = $oversize_warning;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

