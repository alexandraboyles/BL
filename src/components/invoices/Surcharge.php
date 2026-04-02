<?php
namespace Invoices;

use Core\BaseModel;

class Surcharge extends BaseModel {
    private int $adhocChargeSetupId;
    private string $name;
    private string $condition;
    private float $surcharge;
    private string $status;

    public function __construct($adhocChargeSetupId, $name, $condition, $surcharge, $status) {
        parent::__construct();
        $this->adhocChargeSetupId = $adhocChargeSetupId;
        $this->name = $name;
        $this->condition = $condition;
        $this->surcharge = $surcharge;
        $this->status = $status;
    }

    public function getAdhocChargeSetupId(): int {
        return $this->adhocChargeSetupId;
    }

    public function setAdhocChargeSetupId(int $adhocChargeSetupId): void {
        $this->adhocChargeSetupId = $adhocChargeSetupId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCondition(): string {
        return $this->condition;
    }

    public function setCondition(string $condition): void {
        $this->condition = $condition;
    }

    public function getSurcharge(): float {
        return $this->surcharge;
    }

    public function setSurcharge(float $surcharge): void {
        $this->surcharge = $surcharge;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

