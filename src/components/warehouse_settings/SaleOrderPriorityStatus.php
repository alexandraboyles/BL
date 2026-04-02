<?php
namespace WarehouseSettings;

use Core\BaseModel;

class SaleOrderPriorityStatus extends BaseModel {
    private string $name;
    private int $priority;
    private string $description;

    public function __construct($name, $priority, $description) {
        parent::__construct();
        $this->name = $name;
        $this->priority = $priority;
        $this->description = $description;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getPriority(): int {
        return $this->priority;
    }

    public function setPriority(int $priority): void {
        $this->priority = $priority;
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

