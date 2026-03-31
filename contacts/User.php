<?php
namespace Contacts;

use Core\BaseModel;

class User extends BaseModel {
    public $customerId;
    public $fullName;
    public $email;
    public $roles;
    public $warehouses;
    public $mfa;
    public $is_email_verified;

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
