<?php
namespace WarehouseSettings;

use Core\BaseModel;

class WavePick extends BaseModel {
    public $customerId;
    public $runsheetId;
    public $salesOrderId;
    public $dateAdded;
    public $type;
    public $name;
    public $details;
    public $processType;
    public $progress;

    public function __construct($customerId, $runsheetId, $salesOrderId, $dateAdded, $type, $name, $details, $processType, $progress) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->runsheetId = $runsheetId;
        $this->salesOrderId = $salesOrderId;
        $this->dateAdded = $dateAdded;
        $this->type = $type;
        $this->name = $name;
        $this->details = $details;
        $this->processType = $processType;
        $this->progress = $progress;
    }
}