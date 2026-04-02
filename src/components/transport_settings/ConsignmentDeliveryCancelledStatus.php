<?php
namespace TransportSettings;

use Core\BaseModel;

class ConsignmentDeliveryCancelledStatus extends BaseModel {
    private string $statusName;
    private bool $is_charged;

    public function __construct($statusName, $is_charged) {
        parent::__construct();
        $this->statusName = $statusName;
        $this->is_charged = $is_charged;
    }

    public function getStatusName(): string {
        return $this->statusName;
    }

    public function setStatusName(string $statusName): void {
        $this->statusName = $statusName;
    }

    public function getIs_charged(): bool {
        return $this->is_charged;
    }

    public function getIsCharged(): bool {
        return $this->is_charged;
    }

    public function setIs_charged(bool $is_charged): void {
        $this->is_charged = $is_charged;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

