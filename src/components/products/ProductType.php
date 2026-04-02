<?php
namespace Products;

use Core\BaseModel;

class ProductType extends BaseModel {
    private string $name;
    private $code;
    private string $alias;
    private int $priority;
    private bool $is_default;

    public function __construct($name, $code, $alias, $priority, $is_default) {
        parent::__construct();
        $this->name = $name;
        $this->code = $code;
        $this->alias = $alias;
        $this->priority = $priority;
        $this->is_default = $is_default;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code): void {
        $this->code = $code;
    }

    public function getAlias(): string {
        return $this->alias;
    }

    public function setAlias(string $alias): void {
        $this->alias = $alias;
    }

    public function getPriority(): int {
        return $this->priority;
    }

    public function setPriority(int $priority): void {
        $this->priority = $priority;
    }

    public function getIsDefault(): bool {
        return $this->is_default;
    }

    public function setIs_default(bool $is_default): void {
        $this->is_default = $is_default;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

