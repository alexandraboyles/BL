<?php
namespace Contacts;

use Core\BaseModel;

class Contact extends BaseModel {
    public string $id;
    public string $customerId;
    public string $name;
    public string $email;
    public string $phone;

    public function __construct($id, $customerId, $name, $email, $phone) {
        parent::__construct();
        $this->id = $id;
        $this->customerId = $customerId;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }
}
