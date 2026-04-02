<?php
namespace Contacts;

use Core\BaseModel;

class Customer extends BaseModel {
    private string $name;
    private string $contact_phone;
    private string $contact_email;

    public function __construct($name, $contact_phone, $contact_email) {
        parent::__construct();
        $this->name = $name;
        $this->contact_phone = $contact_phone;
        $this->contact_email = $contact_email;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getContactPhone(): string {
        return $this->contact_phone;
    }

    public function setContact_phone(string $contact_phone): void {
        $this->contact_phone = $contact_phone;
    }

    public function getContactEmail(): string {
        return $this->contact_email;
    }

    public function setContact_email(string $contact_email): void {
        $this->contact_email = $contact_email;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

