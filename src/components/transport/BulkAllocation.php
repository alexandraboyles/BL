<?php
namespace Transport;

use Core\BaseModel;

class BulkAllocation extends BaseModel {
    public $customerId;
    public $runsheetId;
    public $deliveryRunId;
    public $driverId;
    public string $referenceNumber;
    public string $serviceType;
    public $requiredDeliveryDate;

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
}
