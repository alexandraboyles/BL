<?php
namespace Misc;

use Core\BaseModel;

class Location extends BaseModel {
    private string $name;
    private string $isle;
    private string $bay;
    private string $shelf;
    private string $type;

    public function __construct($name, $isle, $bay, $shelf, $type) {
        parent::__construct();
        $this->name = $name;
        $this->isle = $isle;
        $this->bay = $bay;
        $this->shelf = $shelf;
        $this->type = $type;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getIsle(): string {
        return $this->isle;
    }

    public function setIsle(string $isle): void {
        $this->isle = $isle;
    }

    public function getBay(): string {
        return $this->bay;
    }

    public function setBay(string $bay): void {
        $this->bay = $bay;
    }

    public function getShelf(): string {
        return $this->shelf;
    }

    public function setShelf(string $shelf): void {
        $this->shelf = $shelf;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

