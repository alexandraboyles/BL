<?php
namespace Integrations;

use Core\BaseModel;

class FTPUser extends BaseModel {
    private int $ftpUserId;
    private string $username;
    private string $password;
    private string $subDirectory;
    private $lastLogin;

    public function __construct($ftpUserId, $username, $password, $subDirectory, $lastLogin) {
        parent::__construct();
        $this->ftpUserId = $ftpUserId;
        $this->username = $username;
        $this->password = $password;
        $this->subDirectory = $subDirectory;
        $this->lastLogin = date('Y-m-d H:i:s');
    }

    public function getFtpUserId(): int {
        return $this->ftpUserId;
    }

    public function setFtpUserId(int $ftpUserId): void {
        $this->ftpUserId = $ftpUserId;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getSubDirectory(): string {
        return $this->subDirectory;
    }

    public function setSubDirectory(string $subDirectory): void {
        $this->subDirectory = $subDirectory;
    }

    public function getLastLogin() {
        return $this->lastLogin;
    }

    public function setLastLogin($lastLogin): void {
        $this->lastLogin = $lastLogin;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

