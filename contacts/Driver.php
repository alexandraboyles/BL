<?php
namespace Contacts;

use Core\BaseModel;

class Driver extends BaseModel {
    public string $id;
    public string $name;
    public string $email;
    public bool $is_online;
    public bool $location_access_available;

    public function __construct($id, $name, $email, $is_online, $location_access_available) {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->is_online = $is_online;
        $this->location_access_available = $location_access_available;
    }
}
