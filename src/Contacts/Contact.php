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

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

