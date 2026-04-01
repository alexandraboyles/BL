<?php
namespace Misc;

use Core\BaseModel;

class ConsignmentErrorChargeAction extends BaseModel {
    public string $name;
    public string $errorCause;

    public function __construct($name, $errorCause) {
        parent::__construct();
        $this->name = $name;
        $this->errorCause = $errorCause;
    }
}
