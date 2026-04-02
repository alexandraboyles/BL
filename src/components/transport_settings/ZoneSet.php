<?php
namespace TransportSettings;

use Core\BaseModel;

class ZoneSet extends BaseModel {
    private string $name;
    private string $type;
    private string $zoneSetCascade;
    private string $status;

    public function __construct($name, $type, $zoneSetCascade, $status) {
        parent::__construct();
        $this->name = $name;
        $this->type = $type;
        $this->zoneSetCascade = $zoneSetCascade;
        $this->status = $status;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function getZoneSetCascade(): string {
        return $this->zoneSetCascade;
    }

    public function setZoneSetCascade(string $zoneSetCascade): void {
        $this->zoneSetCascade = $zoneSetCascade;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

