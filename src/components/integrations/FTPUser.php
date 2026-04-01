<?php
namespace Integrations;

use Core\BaseModel;

class FTPUser extends BaseModel {
    public int $ftpUserId;
    public string $username;
    public string $password;
    public string $subDirectory;
    public $lastLogin;

    public function __construct($ftpUserId, $username, $password, $subDirectory, $lastLogin) {
        parent::__construct();
        $this->ftpUserId = $ftpUserId;
        $this->username = $username;
        $this->password = $password;
        $this->subDirectory = $subDirectory;
        $this->lastLogin = date('Y-m-d H:i:s');
    }
}
