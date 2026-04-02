<?php
namespace Invoices;

use Core\BaseModel;

class AdhocChargeSetup extends BaseModel {
    private string $name;
    private string $chargeStructure;
    private float $rate;
    private string $descriptionTemplate;
    private bool $is_enabled;
    private string $pageVisibleOn;

    public function __construct($name, $chargeStructure, $rate, $descriptionTemplate, $is_enabled, $pageVisibleOn) {
        parent::__construct();
        $this->name = $name;
        $this->chargeStructure = $chargeStructure;
        $this->rate = $rate;
        $this->descriptionTemplate = $descriptionTemplate;
        $this->is_enabled = $is_enabled;
        $this->pageVisibleOn = $pageVisibleOn;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getChargeStructure(): string {
        return $this->chargeStructure;
    }

    public function setChargeStructure(string $chargeStructure): void {
        $this->chargeStructure = $chargeStructure;
    }

    public function getRate(): float {
        return $this->rate;
    }

    public function setRate(float $rate): void {
        $this->rate = $rate;
    }

    public function getDescriptionTemplate(): string {
        return $this->descriptionTemplate;
    }

    public function setDescriptionTemplate(string $descriptionTemplate): void {
        $this->descriptionTemplate = $descriptionTemplate;
    }

    public function getIs_enabled(): bool {
        return $this->is_enabled;
    }

    public function getIsEnabled(): bool {
        return $this->is_enabled;
    }

    public function setIs_enabled(bool $is_enabled): void {
        $this->is_enabled = $is_enabled;
    }

    public function getPageVisibleOn(): string {
        return $this->pageVisibleOn;
    }

    public function setPageVisibleOn(string $pageVisibleOn): void {
        $this->pageVisibleOn = $pageVisibleOn;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

