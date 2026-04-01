<?php
namespace Products;

use Core\BaseModel;

class UnitsOfMeasure extends BaseModel {
    public $productTypeId;
    public $name;
    public $code;
    public $category;
    public $oversize_warning;

    public function __construct($productTypeId, $name, $code, $category, $oversize_warning) {
        parent::__construct();
        $this->productTypeId = $productTypeId;
        $this->name = $name;
        $this->code = $code;
        $this->category = $category;
        $this->oversize_warning = $oversize_warning;
    }
}
