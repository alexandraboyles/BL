<?php
namespace WarehouseSettings;

use Core\BaseModel;

class WavePick extends BaseModel {
    private $customerId;
    private $runsheetId;
    private $salesOrderId;
    private $dateAdded;
    private string $type;
    private string $name;
    private string $details;
    private string $processType;
    private string $progress;

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

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getRunsheetId() {
        return $this->runsheetId;
    }

    public function setRunsheetId($runsheetId): void {
        $this->runsheetId = $runsheetId;
    }

    public function getSalesOrderId() {
        return $this->salesOrderId;
    }

    public function setSalesOrderId($salesOrderId): void {
        $this->salesOrderId = $salesOrderId;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function setDateAdded($dateAdded): void {
        $this->dateAdded = $dateAdded;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getDetails(): string {
        return $this->details;
    }

    public function setDetails(string $details): void {
        $this->details = $details;
    }

    public function getProcessType(): string {
        return $this->processType;
    }

    public function setProcessType(string $processType): void {
        $this->processType = $processType;
    }

    public function getProgress(): string {
        return $this->progress;
    }

    public function setProgress(string $progress): void {
        $this->progress = $progress;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}
