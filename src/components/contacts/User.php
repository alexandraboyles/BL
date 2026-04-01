<?php
namespace Contacts;

use Core\BaseModel;

class User extends BaseModel {
    public $customerId;
    public string $fullName;
    public string $email;
    public string $roles;
    public string $warehouses;
    public string $mfa;
    public bool $is_email_verified;

    public function __construct($customerId, $fullName, $email, $roles, $warehouses, $mfa, $is_email_verified) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->roles = $roles;
        $this->warehouses = $warehouses;
        $this->mfa = $mfa;
        $this->is_email_verified = $is_email_verified;
    }
}
