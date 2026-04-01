<?php
namespace Tools;

use Core\BaseModel;

class RegexDefinition extends BaseModel {
    public string $name;
    public string $regex;
    public string $status;

    public function __construct($name, $regex, $status) {
        parent::__construct();
        $this->name = $name;
        $this->regex = $regex;
        $this->status = $status;
    }
}
