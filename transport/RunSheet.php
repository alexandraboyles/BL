<?php
namespace Transport;

use Core\BaseModel;

class RunSheet extends BaseModel {
    public $deliveryRunId;
    public $consignmentId;
    public $driverId;
    public $name;
    public $totalCashOnDelivery;
    public $income;
    public $is_complete;

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
}
