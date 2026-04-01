<?php
namespace WarehouseSettings;

use Core\BaseModel;

class WavePick extends BaseModel {
    public $customerId;
    public $runsheetId;
    public $salesOrderId;
    public $dateAdded;
    public string $type;
    public string $name;
    public string $details;
    public string $processType;
    public string $progress;

    public function __construct($customerId, $runsheetId, $salesOrderId, $dateAdded, $type, $name, $details, $processType, $progress) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->runsheetId = $runsheetId;
        $this->salesOrderId = $salesOrderId;
        $this->dateAdded = date('Y-m-d H:i:s');
        $this->type = $type;
        $this->name = $name;
        $this->details = $details;
        $this->processType = $processType;
        $this->progress = $progress;
    }
}