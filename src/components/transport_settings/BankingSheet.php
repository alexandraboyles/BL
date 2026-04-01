<?php
namespace TransportSettings;

use Core\BaseModel;

class BankingSheet extends BaseModel {
    public $customerId;
    public $dateAdded;
    public $status;
    public $value;

    public function __construct($customerId, $dateAdded, $status, $value) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->dateAdded = $dateAdded;
        $this->status = $status;
        $this->value = $value;
    }
}
