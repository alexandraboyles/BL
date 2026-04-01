<?php
namespace Products;

use Core\BaseModel;

class ProductType extends BaseModel {
    public string $name;
    public $code;
    public string $alias;
    public int $priority;
    public bool $is_default;

    public function __construct($name, $code, $alias, $priority, $is_default) {
        parent::__construct();
        $this->name = $name;
        $this->code = $code;
        $this->alias = $alias;
        $this->priority = $priority;
        $this->is_default = $is_default;
    }
}
