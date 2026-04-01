<?php
namespace TransportSettings;

use Core\BaseModel;

class ConsignmentDeliveryCancelledStatus extends BaseModel {
    public string $statusName;
    public bool $is_charged;

    public function __construct($statusName, $is_charged) {
        parent::__construct();
        $this->statusName = $statusName;
        $this->is_charged = $is_charged;
    }
}
