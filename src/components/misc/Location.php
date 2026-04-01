<?php
namespace Misc;

use Core\BaseModel;

class Location extends BaseModel {
    public string $name;
    public string $isle;
    public string $bay;
    public string $shelf;
    public string $type;

    public function __construct($name, $isle, $bay, $shelf, $type) {
        parent::__construct();
        $this->name = $name;
        $this->isle = $isle;
        $this->bay = $bay;
        $this->shelf = $shelf;
        $this->type = $type;
    }
}
