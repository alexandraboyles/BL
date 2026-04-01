<?php
namespace Contacts;

use Core\BaseModel;

class Contact extends BaseModel {
    public $customerId;
    public string $name;
    public string $email;
    public string $phone;

    public function __construct($customerId, $name, $email, $phone) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }
}
