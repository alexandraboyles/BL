<?php
namespace TransportSettings;

use Core\BaseModel;

class OrganizationSetting extends BaseModel {
    public $nickname;
    public $website;
    public $telephone;
    public $defaultCurrency;

    public function __construct($nickname, $website, $telephone, $defaultCurrency) {
        parent::__construct();
        $this->nickname = $nickname;
        $this->website = $website;
        $this->telephone = $telephone;
        $this->defaultCurrency = $defaultCurrency;
    }
}
