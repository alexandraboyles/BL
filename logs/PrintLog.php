<?php
namespace Logs;

use Core\BaseModel;

class PrintLog extends BaseModel {
    public $created;
    public $title;
    public $entity;
    public $printer;
    public $computer;
    public $warehouse;

    public function __construct($title, $entity, $printer, $computer, $warehouse) {
        parent::__construct();
        $this->created = date('Y-m-d H:i:s');
        $this->title = $title;
        $this->entity = $entity;
        $this->printer = $printer;
        $this->computer = $computer;
        $this->warehouse = $warehouse;
    }
}
