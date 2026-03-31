<?php
namespace Invoices;

use Core\BaseModel;

class AdhocChargeSetup extends BaseModel {
    public $name;
    public $chargeStructure;
    public $rate;
    public $descriptionTemplate;
    public $is_enabled;
    public $pageVisibleOn;

    public function __construct($name, $chargeStructure, $rate, $descriptionTemplate, $is_enabled, $pageVisibleOn) {
        parent::__construct();
        $this->name = $name;
        $this->chargeStructure = $chargeStructure;
        $this->rate = $rate;
        $this->descriptionTemplate = $descriptionTemplate;
        $this->is_enabled = $is_enabled;
        $this->pageVisibleOn = $pageVisibleOn;
    }
}
