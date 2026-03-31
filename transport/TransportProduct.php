<?php
namespace Transport;

use Core\BaseModel;

class TransportProduct extends BaseModel {
    public $name;
    public $code;
    public $length;
    public $width;
    public $height;
    public $weight;
    public $barcode;

    public function __construct($name, $code, $length, $width, $height, $weight, $barcode) {
        parent::__construct();
        $this->name = $name;
        $this->code = $code;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->weight = $weight;
        $this->barcode = $barcode;
    }
}
