<?php
namespace Transport;

use Core\BaseModel;

class TransportProduct extends BaseModel {
    private string $name;
    private string $code;
    private float $length;
    private float $width;
    private float $height;
    private float $weight;
    private string $barcode;

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

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function setCode(string $code): void {
        $this->code = $code;
    }

    public function getLength(): float {
        return $this->length;
    }

    public function setLength(float $length): void {
        $this->length = $length;
    }

    public function getWidth(): float {
        return $this->width;
    }

    public function setWidth(float $width): void {
        $this->width = $width;
    }

    public function getHeight(): float {
        return $this->height;
    }

    public function setHeight(float $height): void {
        $this->height = $height;
    }

    public function getWeight(): float {
        return $this->weight;
    }

    public function setWeight(float $weight): void {
        $this->weight = $weight;
    }

    public function getBarcode(): string {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): void {
        $this->barcode = $barcode;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

