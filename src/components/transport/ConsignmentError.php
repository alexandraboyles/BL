<?php
namespace Transport;

use Core\BaseModel;

class ConsignmentError extends BaseModel {
    public $consignmentId;
    public $customerId;
    public string $name;
    public string $causedBy;
    public string $chargeAction;
    public string $status;
    public string $customerDecision;

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
}
