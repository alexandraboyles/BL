<?php
namespace Invoices;

use Core\BaseModel;

class Account extends BaseModel {
    private string $name;
    private string $description;
    private bool $display_when_no_value;

    public function __construct($name, $description, $display_when_no_value) {
        parent::__construct();
        $this->name = $name;
        $this->description = $description;
        $this->display_when_no_value = $display_when_no_value;
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

    public function getDisplayWhenNoValue(): bool {
        return $this->display_when_no_value;
    }

    public function setDisplay_when_no_value(bool $display_when_no_value): void {
        $this->display_when_no_value = $display_when_no_value;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

