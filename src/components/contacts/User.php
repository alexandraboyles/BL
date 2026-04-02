<?php
namespace Contacts;

use Core\BaseModel;

class User extends BaseModel {
    private $customerId;
    private string $fullName;
    private string $email;
    private string $roles;
    private string $warehouses;
    private string $mfa;
    private bool $is_email_verified;

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

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void {
        $this->fullName = $fullName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getRoles(): string {
        return $this->roles;
    }

    public function setRoles(string $roles): void {
        $this->roles = $roles;
    }

    public function getWarehouses(): string {
        return $this->warehouses;
    }

    public function setWarehouses(string $warehouses): void {
        $this->warehouses = $warehouses;
    }

    public function getMfa(): string {
        return $this->mfa;
    }

    public function setMfa(string $mfa): void {
        $this->mfa = $mfa;
    }

    public function getIs_email_verified(): bool {
        return $this->is_email_verified;
    }

    public function getIsEmailVerified(): bool {
        return $this->is_email_verified;
    }

    public function setIs_email_verified(bool $is_email_verified): void {
        $this->is_email_verified = $is_email_verified;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

