<?php
namespace TransportSettings;

use Core\BaseModel;

class ConsignmentCashOnDelivery extends BaseModel {
    private $consignmentId;
    private $driverId;
    private $customerId;
    private string $paymentType;
    private string $status;
    private float $amount;
    private string $comments;

    public function __construct($consignmentId, $driverId, $customerId, $paymentType, $status, $amount, $comments) {
        parent::__construct();
        $this->consignmentId = $consignmentId;
        $this->driverId = $driverId;
        $this->customerId = $customerId;
        $this->paymentType = $paymentType;
        $this->status = $status;
        $this->amount = $amount;
        $this->comments = $comments;
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

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getPaymentType(): string {
        return $this->paymentType;
    }

    public function setPaymentType(string $paymentType): void {
        $this->paymentType = $paymentType;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function getComments(): string {
        return $this->comments;
    }

    public function setComments(string $comments): void {
        $this->comments = $comments;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

