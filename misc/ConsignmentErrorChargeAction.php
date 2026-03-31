<?php
namespace Misc;

use Core\BaseModel;

class ConsignmentErrorChargeAction extends BaseModel {
    public $consignmentId;
    public $customerId;
    public $action;
    public $status;

    public function __construct($consignmentId, $customerId, $action, $status) {
        parent::__construct();
        $this->consignmentId = $consignmentId;
        $this->customerId = $customerId;
        $this->action = $action;
        $this->status = $status;
    }
}
