<?php
namespace Core;

abstract class BaseModel {
    protected $id;

    public function __construct($id = null) {
        $this->id = $id ?? uniqid();
    }

    public function getId() {
        return $this->id;
    }

    public function toArray() {
        return get_object_vars($this);
    }

    public function __toString() {
        return json_encode($this->toArray());
    }
}
