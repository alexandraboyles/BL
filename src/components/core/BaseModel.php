<?php
namespace Core;

abstract class BaseModel {
    protected $id;

    public function __construct($id = null) {
        $this->id = $id ?? self::uuidV4();
    }

    public function getId() {
        return $this->id;
    }

    private static function uuidV4() {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function toArray() {
        return get_object_vars($this);
    }

    public function __toString() {
        return json_encode($this->toArray());
    }
}
