<?php
namespace Transport;

use Core\BaseModel;

class TransportLane extends BaseModel {
    private $deliveryRunId;
    private string $name;
    private $effectiveDate;
    private $expiryDate;
    private string $fromZone;
    private string $toZone;

    public function __construct($deliveryRunId, $name, $effectiveDate, $expiryDate, $fromZone, $toZone) {
        parent::__construct();
        $this->deliveryRunId = $deliveryRunId;
        $this->name = $name;
        $this->effectiveDate = $effectiveDate;
        $this->expiryDate = $expiryDate;
        $this->fromZone = $fromZone;
        $this->toZone = $toZone;
    }

    public function getDeliveryRunId() {
        return $this->deliveryRunId;
    }

    public function setDeliveryRunId($deliveryRunId): void {
        $this->deliveryRunId = $deliveryRunId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getEffectiveDate() {
        return $this->effectiveDate;
    }

    public function setEffectiveDate($effectiveDate): void {
        $this->effectiveDate = $effectiveDate;
    }

    public function getExpiryDate() {
        return $this->expiryDate;
    }

    public function setExpiryDate($expiryDate): void {
        $this->expiryDate = $expiryDate;
    }

    public function getFromZone(): string {
        return $this->fromZone;
    }

    public function setFromZone(string $fromZone): void {
        $this->fromZone = $fromZone;
    }

    public function getToZone(): string {
        return $this->toZone;
    }

    public function setToZone(string $toZone): void {
        $this->toZone = $toZone;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

