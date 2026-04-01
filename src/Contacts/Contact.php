<?php
namespace Contacts;

use Core\BaseModel;

class Contact extends BaseModel {
    private $customerId;
    private string $name;
    private string $email;
    private string $phone;

    public function __construct($customerId, $name, $email, $phone) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }
}
