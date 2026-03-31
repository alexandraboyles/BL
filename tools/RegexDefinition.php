<?php
namespace Tools;

use Core\BaseModel;

class RegexDefinition extends BaseModel {
    public $name;
    public $regex;
    public $status;

    public function __construct($name, $regex, $status) {
        parent::__construct();
        $this->name = $name;
        $this->regex = $regex;
        $this->status = $status;
    }
}
