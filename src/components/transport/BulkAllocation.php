<?php
namespace Transport;

use Core\BaseModel;

class BulkAllocation extends BaseModel {
    private $customerId;
    private $runsheetId;
    private $deliveryRunId;
    private $driverId;
    private string $referenceNumber;
    private string $serviceType;
    private $requiredDeliveryDate;

    public function __construct($customerId, $runsheetId, $deliveryRunId, $driverId, $referenceNumber, $serviceType, $requiredDeliveryDate) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->runsheetId = $runsheetId;
        $this->deliveryRunId = $deliveryRunId;
        $this->driverId = $driverId;
        $this->referenceNumber = $referenceNumber;
        $this->serviceType = $serviceType;
        $this->requiredDeliveryDate = $requiredDeliveryDate;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getRunsheetId() {
        return $this->runsheetId;
    }

    public function setRunsheetId($runsheetId): void {
        $this->runsheetId = $runsheetId;
    }

    public function getDeliveryRunId() {
        return $this->deliveryRunId;
    }

    public function setDeliveryRunId($deliveryRunId): void {
        $this->deliveryRunId = $deliveryRunId;
    }

    public function getDriverId() {
        return $this->driverId;
    }

    public function setDriverId($driverId): void {
        $this->driverId = $driverId;
    }

    public function getReferenceNumber(): string {
        return $this->referenceNumber;
    }

    public function setReferenceNumber(string $referenceNumber): void {
        $this->referenceNumber = $referenceNumber;
    }

    public function getServiceType(): string {
        return $this->serviceType;
    }

    public function setServiceType(string $serviceType): void {
        $this->serviceType = $serviceType;
    }

    public function getRequiredDeliveryDate() {
        return $this->requiredDeliveryDate;
    }

    public function setRequiredDeliveryDate($requiredDeliveryDate): void {
        $this->requiredDeliveryDate = $requiredDeliveryDate;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

