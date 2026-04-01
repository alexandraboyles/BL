<?php
namespace Transport;

use Core\BaseModel;

class TransportProduct extends BaseModel {
    public string $name;
    public string $code;
    public float $length;
    public float $width;
    public float $height;
    public float $weight;
    public string $barcode;

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
