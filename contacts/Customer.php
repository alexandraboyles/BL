<?php
namespace Contacts;

use Core\BaseModel;

class Customer extends BaseModel {
    public string $id;
    public string $name;
    public string $contact_phone;
    public string $contact_email;

    public function __construct($id, $name, $contact_phone, $contact_email) {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->contact_phone = $contact_phone;
        $this->contact_email = $contact_email;
    }
}
