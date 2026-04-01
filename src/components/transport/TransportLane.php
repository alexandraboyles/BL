<?php
namespace Transport;

use Core\BaseModel;

class TransportLane extends BaseModel {
    public $deliveryRunId;
    public $name;
    public $effectiveDate;
    public $expiryDate;
    public $fromZone;
    public $toZone;

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
