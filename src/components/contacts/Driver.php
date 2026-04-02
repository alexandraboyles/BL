<?php
namespace Contacts;

use Core\BaseModel;

class Driver extends BaseModel {
    private string $name;
    private string $email;
    private bool $is_online;
    private bool $location_access_available;

    public function __construct($name, $email, $is_online, $location_access_available) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
        $this->is_online = $is_online;
        $this->location_access_available = $location_access_available;
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

    public function getIsOnline(): bool {
        return $this->is_online;
    }

    public function setIs_online(bool $is_online): void {
        $this->is_online = $is_online;
    }

    public function getLocationAccessAvailable(): bool {
        return $this->location_access_available;
    }

    public function setLocation_access_available(bool $location_access_available): void {
        $this->location_access_available = $location_access_available;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

