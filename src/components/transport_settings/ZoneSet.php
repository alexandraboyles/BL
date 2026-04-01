<?php
namespace TransportSettings;

use Core\BaseModel;

class ZoneSet extends BaseModel {
    public string $name;
    public string $type;
    public string $zoneSetCascade;
    public string $status;

    public function __construct($name, $type, $zoneSetCascade, $status) {
        parent::__construct();
        $this->name = $name;
        $this->type = $type;
        $this->zoneSetCascade = $zoneSetCascade;
        $this->status = $status;
    }
}
