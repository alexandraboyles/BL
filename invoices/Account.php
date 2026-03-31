<?php
namespace Invoices;

use Core\BaseModel;

class Account extends BaseModel {
    public $name;
    public $description;
    public $display_when_no_value;

    public function __construct($name, $description, $display_when_no_value) {
        parent::__construct();
        $this->name = $name;
        $this->description = $description;
        $this->display_when_no_value = $display_when_no_value;
    }
}
