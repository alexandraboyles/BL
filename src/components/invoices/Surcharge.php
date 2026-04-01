<?php
namespace Invoices;

use Core\BaseModel;

class Surcharge extends BaseModel {
    public int $adhocChargeSetupId;
    public string $name;
    public string $condition;
    public float $surcharge;
    public string $status;

    public function __construct($adhocChargeSetupId, $name, $condition, $surcharge, $status) {
        parent::__construct();
        $this->adhocChargeSetupId = $adhocChargeSetupId;
        $this->name = $name;
        $this->condition = $condition;
        $this->surcharge = $surcharge;
        $this->status = $status;
    }
}
