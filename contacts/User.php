<?php
namespace Contacts;

use Core\BaseModel;

class User extends BaseModel {
    public string $id;
    public string $customerId;
    public string $fullName;
    public string $email;
    public string $roles;
    public string $warehouses;
    public string $mfa;
    public bool $is_email_verified;

    public function __construct($id, $customerId, $fullName, $email, $roles, $warehouses, $mfa, $is_email_verified) {
        parent::__construct();
        $this->id = $id;
        $this->customerId = $customerId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->roles = $roles;
        $this->warehouses = $warehouses;
        $this->mfa = $mfa;
        $this->is_email_verified = $is_email_verified;
    }
}
