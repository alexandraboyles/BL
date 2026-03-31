<?php
namespace Invoices;

use Core\BaseModel;

class Surcharge extends BaseModel {
    public $adhocChargeSetupId;
    public $name;
    public $condition;
    public $surcharge;
    public $status;

    public function __construct($adhocChargeSetupId, $name, $condition, $surcharge, $status) {
        parent::__construct();
        $this->adhocChargeSetupId = $adhocChargeSetupId;
        $this->name = $name;
        $this->condition = $condition;
        $this->surcharge = $surcharge;
        $this->status = $status;
    }
}
