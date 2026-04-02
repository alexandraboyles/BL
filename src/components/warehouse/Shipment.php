<?php
namespace Warehouse;

use Core\BaseModel;

class Shipment extends BaseModel {
    private string $status;
    private int $numOfContainers;
    private int $numOfPOs;

    public function __construct($status, $numOfContainers, $numOfPOs) {
        parent::__construct();
        $this->status = $status;
        $this->numOfContainers = $numOfContainers;
        $this->numOfPOs = $numOfPOs;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getNumOfContainers(): int {
        return $this->numOfContainers;
    }

    public function setNumOfContainers(int $numOfContainers): void {
        $this->numOfContainers = $numOfContainers;
    }

    public function getNumOfPOs(): int {
        return $this->numOfPOs;
    }

    public function setNumOfPOs(int $numOfPOs): void {
        $this->numOfPOs = $numOfPOs;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

