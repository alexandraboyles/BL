<?php
namespace Transport;

use Core\BaseModel;

class Manifest extends BaseModel {
    public $customerId;
    public $consignmentId;
    public $requires_pickup;
    public $info;
    public $is_finalized;
    public $assignedToInvoice;
    public $is_there_any_charging_error;
    public $storageChargeName;
    public $storageChargeAmount;

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
}
