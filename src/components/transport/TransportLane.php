<?php
namespace Transport;

use Core\BaseModel;

class TransportLane extends BaseModel {
    public $deliveryRunId;
    public string $name;
    public $effectiveDate;
    public $expiryDate;
    public string $fromZone;
    public string $toZone;

    public function __construct($deliveryRunId, $name, $effectiveDate, $expiryDate, $fromZone, $toZone) {
        parent::__construct();
        $this->deliveryRunId = $deliveryRunId;
        $this->name = $name;
        $this->effectiveDate = $effectiveDate;
        $this->expiryDate = $expiryDate;
        $this->fromZone = $fromZone;
        $this->toZone = $toZone;
    }
}
