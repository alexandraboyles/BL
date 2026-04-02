<?php
namespace TransportSettings;

use Core\BaseModel;

class NotificationEmail extends BaseModel {
    private string $name;
    private string $email;

    public function __construct($name, $email) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
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

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

