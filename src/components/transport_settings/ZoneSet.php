<?php
namespace TransportSettings;

use Core\BaseModel;

class ZoneSet extends BaseModel {
    public $name;
    public $type;
    public $zoneSetCascade;
    public $status;

    public function __construct($name, $type, $zoneSetCascade, $status) {
        parent::__construct();
        $this->name = $name;
        $this->type = $type;
        $this->zoneSetCascade = $zoneSetCascade;
        $this->status = $status;
    }
}
