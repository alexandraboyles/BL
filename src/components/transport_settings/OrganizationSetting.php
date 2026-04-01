<?php
namespace TransportSettings;

use Core\BaseModel;

class OrganizationSetting extends BaseModel {
    public string $nickname;
    public string $website;
    public int $telephone;
    public string $defaultCurrency;

    public function __construct($nickname, $website, $telephone, $defaultCurrency) {
        parent::__construct();
        $this->nickname = $nickname;
        $this->website = $website;
        $this->telephone = $telephone;
        $this->defaultCurrency = $defaultCurrency;
    }
}
