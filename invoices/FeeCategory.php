<?php
namespace Invoices;

use Core\BaseModel;

class FeeCategory extends BaseModel {
    public $appliesTo;
    public $account;
    public $name;
    public $counts_toward_minimum_charges;
    public $is_name_editable;

    public function __construct($appliesTo, $account, $name, $counts_toward_minimum_charges, $is_name_editable) {
        parent::__construct();
        $this->appliesTo = $appliesTo;
        $this->account = $account;
        $this->name = $name;
        $this->counts_toward_minimum_charges = $counts_toward_minimum_charges;
        $this->is_name_editable = $is_name_editable;
    }
}
