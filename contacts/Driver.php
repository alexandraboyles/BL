<?php
namespace Contacts;

use Core\BaseModel;

class Driver extends BaseModel {
    public $name;
    public $email;
    public $is_online;
    public $location_access_available;

    public function __construct($name, $email, $is_online, $location_access_available) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
        $this->is_online = $is_online;
        $this->location_access_available = $location_access_available;
    }
}
