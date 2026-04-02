<?php
namespace Transport;

use Core\BaseModel;

class DeliveryRun extends BaseModel {
    private string $name;
    private string $carrier;

    public function __construct($name, $carrier) {
        parent::__construct();
        $this->name = $name;
        $this->carrier = $carrier;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCarrier(): string {
        return $this->carrier;
    }

    public function setCarrier(string $carrier): void {
        $this->carrier = $carrier;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}
