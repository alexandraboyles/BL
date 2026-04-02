<?php
namespace Transport;

use Core\BaseModel;

class ConsignmentError extends BaseModel {
    private $consignmentId;
    private $customerId;
    private string $name;
    private string $causedBy;
    private string $chargeAction;
    private string $status;
    private string $customerDecision;

    public function __construct($consignmentId, $customerId, $name, $causedBy, $chargeAction, $status, $customerDecision) {
        parent::__construct();
        $this->consignmentId = $consignmentId;
        $this->customerId = $customerId;
        $this->name = $name;
        $this->causedBy = $causedBy;
        $this->chargeAction = $chargeAction;
        $this->status = $status;
        $this->customerDecision = $customerDecision;
    }

    public function getConsignmentId() {
        return $this->consignmentId;
    }

    public function setConsignmentId($consignmentId): void {
        $this->consignmentId = $consignmentId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCausedBy(): string {
        return $this->causedBy;
    }

    public function setCausedBy(string $causedBy): void {
        $this->causedBy = $causedBy;
    }

    public function getChargeAction(): string {
        return $this->chargeAction;
    }

    public function setChargeAction(string $chargeAction): void {
        $this->chargeAction = $chargeAction;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getCustomerDecision(): string {
        return $this->customerDecision;
    }

    public function setCustomerDecision(string $customerDecision): void {
        $this->customerDecision = $customerDecision;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

