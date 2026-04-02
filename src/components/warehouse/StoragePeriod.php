<?php
namespace Warehouse;

use Core\BaseModel;

class StoragePeriod extends BaseModel {
    private int $storagePeriodId;
    private $customerId;
    private $startDate;
    private $endDate;
    private $dateAdded;
    private bool $automatically_created;

    public function __construct($storagePeriodId, $customerId, $startDate, $endDate, $dateAdded, $automatically_created) {
        parent::__construct();
        $this->storagePeriodId = $storagePeriodId;
        $this->customerId = $customerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->dateAdded = date('Y-m-d H:i:s');
        $this->automatically_created = $automatically_created;
    }

    public function getStoragePeriodId(): int {
        return $this->storagePeriodId;
    }

    public function setStoragePeriodId(int $storagePeriodId): void {
        $this->storagePeriodId = $storagePeriodId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate): void {
        $this->startDate = $startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate): void {
        $this->endDate = $endDate;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function setDateAdded($dateAdded): void {
        $this->dateAdded = $dateAdded;
    }

    public function getAutomatically_created(): bool {
        return $this->automatically_created;
    }

    public function getAutomaticallyCreated(): bool {
        return $this->automatically_created;
    }

    public function setAutomatically_created(bool $automatically_created): void {
        $this->automatically_created = $automatically_created;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

