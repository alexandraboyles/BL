<?php
namespace Integrations;

use Core\BaseModel;

class Parser extends BaseModel {
    public $customerId;
    public $name;
    public $className;
    public $class;
    public $type;
    public $acceptedFiletypes;
    public $toAddress;

    public function __construct($customerId, $name, $className, $class, $type, $acceptedFiletypes, $toAddress) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->name = $name;
        $this->className = $className;
        $this->class = $class;
        $this->type = $type;
        $this->acceptedFiletypes = $acceptedFiletypes;
        $this->toAddress = $toAddress;
    }
}
