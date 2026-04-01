<?php
namespace TransportSettings;

use Core\BaseModel;

class Carrier extends BaseModel {
    public string $name;
    public bool $on_forwarder;
    public string $status;

    public function __construct($name, $on_forwarder, $status) {
        parent::__construct();
        $this->name = $name;
        $this->on_forwarder = $on_forwarder;
        $this->status = $status;
    }
}
