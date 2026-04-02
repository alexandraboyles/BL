<?php
namespace TransportSettings;

use Core\BaseModel;

class OrganizationSetting extends BaseModel {
    private string $nickname;
    private string $website;
    private int $telephone;
    private string $defaultCurrency;

    public function __construct($nickname, $website, $telephone, $defaultCurrency) {
        parent::__construct();
        $this->nickname = $nickname;
        $this->website = $website;
        $this->telephone = $telephone;
        $this->defaultCurrency = $defaultCurrency;
    }

    public function getNickname(): string {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void {
        $this->nickname = $nickname;
    }

    public function getWebsite(): string {
        return $this->website;
    }

    public function setWebsite(string $website): void {
        $this->website = $website;
    }

    public function getTelephone(): int {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): void {
        $this->telephone = $telephone;
    }

    public function getDefaultCurrency(): string {
        return $this->defaultCurrency;
    }

    public function setDefaultCurrency(string $defaultCurrency): void {
        $this->defaultCurrency = $defaultCurrency;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

