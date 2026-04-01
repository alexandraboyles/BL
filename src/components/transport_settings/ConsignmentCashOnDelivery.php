<?php
namespace TransportSettings;

use Core\BaseModel;

class ConsignmentCashOnDelivery extends BaseModel {
    public $consignmentId;
    public $driverId;
    public $customerId;
    public $paymentType;
    public $status;
    public $amount;
    public $comments;

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
}
