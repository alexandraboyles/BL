<?php
namespace Transport;

use Core\BaseModel;

class Manifest extends BaseModel {
    private $customerId;
    private $consignmentId;
    private bool $requires_pickup;
    private string $info;
    private bool $is_finalized;
    private string $assignedToInvoice;
    private bool $is_there_any_charging_error;
    private string $storageChargeName;
    private float $storageChargeAmount;

    public function __construct($customerId, $consignmentId, $requires_pickup, $info, $is_finalized, $assignedToInvoice, $is_there_any_charging_error, $storageChargeName, $storageChargeAmount) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->consignmentId = $consignmentId;
        $this->requires_pickup = $requires_pickup;
        $this->info = $info;
        $this->is_finalized = $is_finalized;
        $this->assignedToInvoice = $assignedToInvoice;
        $this->is_there_any_charging_error = $is_there_any_charging_error;
        $this->storageChargeName = $storageChargeName;
        $this->storageChargeAmount = $storageChargeAmount;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getConsignmentId() {
        return $this->consignmentId;
    }

    public function setConsignmentId($consignmentId): void {
        $this->consignmentId = $consignmentId;
    }

    public function getRequires_pickup(): bool {
        return $this->requires_pickup;
    }

    public function getRequiresPickup(): bool {
        return $this->requires_pickup;
    }

    public function setRequires_pickup(bool $requires_pickup): void {
        $this->requires_pickup = $requires_pickup;
    }

    public function getInfo(): string {
        return $this->info;
    }

    public function setInfo(string $info): void {
        $this->info = $info;
    }

    public function getIs_finalized(): bool {
        return $this->is_finalized;
    }

    public function getIsFinalized(): bool {
        return $this->is_finalized;
    }

    public function setIs_finalized(bool $is_finalized): void {
        $this->is_finalized = $is_finalized;
    }

    public function getAssignedToInvoice(): string {
        return $this->assignedToInvoice;
    }

    public function setAssignedToInvoice(string $assignedToInvoice): void {
        $this->assignedToInvoice = $assignedToInvoice;
    }

    public function getIs_there_any_charging_error(): bool {
        return $this->is_there_any_charging_error;
    }

    public function getIsThereAnyChargingError(): bool {
        return $this->is_there_any_charging_error;
    }

    public function setIs_there_any_charging_error(bool $is_there_any_charging_error): void {
        $this->is_there_any_charging_error = $is_there_any_charging_error;
    }

    public function getStorageChargeName(): string {
        return $this->storageChargeName;
    }

    public function setStorageChargeName(string $storageChargeName): void {
        $this->storageChargeName = $storageChargeName;
    }

    public function getStorageChargeAmount(): float {
        return $this->storageChargeAmount;
    }

    public function setStorageChargeAmount(float $storageChargeAmount): void {
        $this->storageChargeAmount = $storageChargeAmount;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

