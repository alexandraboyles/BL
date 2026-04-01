<?php
namespace Warehouse;

use Core\BaseModel;

class StoragePeriod extends BaseModel {
    public $storagePeriodId;
    public $customerId;
    public $startDate;
    public $endDate;
    public $dateAdded;
    public $automatically_created;

    public function __construct($storagePeriodId, $customerId, $startDate, $endDate, $dateAdded, $automatically_created) {
        parent::__construct();
        $this->storagePeriodId = $storagePeriodId;
        $this->customerId = $customerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->dateAdded = $dateAdded;
        $this->automatically_created = $automatically_created;
    }
}
