<?php
namespace Contacts;

use Core\BaseModel;

class Customer extends BaseModel {
    public $name;
    public $contact_phone;
    public $contact_email;

    public function __construct($name, $contact_phone, $contact_email) {
        parent::__construct();
        $this->name = $name;
        $this->contact_phone = $contact_phone;
        $this->contact_email = $contact_email;
    }
}
