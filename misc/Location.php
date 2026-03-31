<?php
namespace Misc;

use Core\BaseModel;

class Location extends BaseModel {
    public $name;
    public $description;

    public function __construct($name, $description) {
        parent::__construct();
        $this->name = $name;
        $this->description = $description;
    }
}
