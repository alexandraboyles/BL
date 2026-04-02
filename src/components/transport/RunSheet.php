<?php
namespace Transport;

use Core\BaseModel;

class RunSheet extends BaseModel {
    private $deliveryRunId;
    private $consignmentId;
    private $driverId;
    private string $name;
    private float $totalCashOnDelivery;
    private float $income;
    private bool $is_complete;

    public function __construct($deliveryRunId, $consignmentId, $driverId, $name, $totalCashOnDelivery, $income, $is_complete) {
        parent::__construct();
        $this->deliveryRunId = $deliveryRunId;
        $this->consignmentId = $consignmentId;
        $this->driverId = $driverId;
        $this->name = $name;
        $this->totalCashOnDelivery = $totalCashOnDelivery;
        $this->income = $income;
        $this->is_complete = $is_complete;
    }

    public function getDeliveryRunId() {
        return $this->deliveryRunId;
    }

    public function setDeliveryRunId($deliveryRunId): void {
        $this->deliveryRunId = $deliveryRunId;
    }

    public function getConsignmentId() {
        return $this->consignmentId;
    }

    public function setConsignmentId($consignmentId): void {
        $this->consignmentId = $consignmentId;
    }

    public function getDriverId() {
        return $this->driverId;
    }

    public function setDriverId($driverId): void {
        $this->driverId = $driverId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getTotalCashOnDelivery(): float {
        return $this->totalCashOnDelivery;
    }

    public function setTotalCashOnDelivery(float $totalCashOnDelivery): void {
        $this->totalCashOnDelivery = $totalCashOnDelivery;
    }

    public function getIncome(): float {
        return $this->income;
    }

    public function setIncome(float $income): void {
        $this->income = $income;
    }

    public function getIsComplete(): bool {
        return $this->is_complete;
    }

    public function setIs_complete(bool $is_complete): void {
        $this->is_complete = $is_complete;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

