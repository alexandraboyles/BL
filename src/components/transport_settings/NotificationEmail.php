<?php
namespace TransportSettings;

use Core\BaseModel;

class NotificationEmail extends BaseModel {
    public string $name;
    public string $email;

    public function __construct($name, $email) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
    }
}
