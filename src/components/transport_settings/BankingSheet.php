<?php
namespace TransportSettings;

use Core\BaseModel;

class BankingSheet extends BaseModel {
    public $customerId;
    public $dateAdded;
    public string $status;
    public string $value;

    public function __construct($customerId, $dateAdded, $status, $value) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->dateAdded = date('Y-m-d H:i:s');
        $this->status = $status;
        $this->value = $value;
    }
}
