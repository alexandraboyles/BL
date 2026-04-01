<?php
namespace Integrations;

use Core\BaseModel;

class FTPUser extends BaseModel {
    public $ftpUserId;
    public $username;
    public $password;
    public $subDirectory;
    public $lastLogin;

    public function __construct($ftpUserId, $username, $password, $subDirectory, $lastLogin) {
        parent::__construct();
        $this->ftpUserId = $ftpUserId;
        $this->username = $username;
        $this->password = $password;
        $this->subDirectory = $subDirectory;
        $this->lastLogin = $lastLogin;
    }
}
