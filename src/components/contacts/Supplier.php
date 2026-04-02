<?php
namespace Contacts;

use Core\BaseModel;

class Supplier extends BaseModel {
    private int $rateCardId;
    private string $companyName;
    private string $email;
    private string $telNo;
    private string $accountingConnector;

    public function __construct($rateCardId, $companyName, $email, $telNo, $accountingConnector) {
        parent::__construct();
        $this->rateCardId = $rateCardId;
        $this->companyName = $companyName;
        $this->email = $email;
        $this->telNo = $telNo;
        $this->accountingConnector = $accountingConnector;
    }

    public function getRateCardId(): int {
        return $this->rateCardId;
    }

    public function setRateCardId(int $rateCardId): void {
        $this->rateCardId = $rateCardId;
    }

    public function getCompanyName(): string {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): void {
        $this->companyName = $companyName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getTelNo(): string {
        return $this->telNo;
    }

    public function setTelNo(string $telNo): void {
        $this->telNo = $telNo;
    }

    public function getAccountingConnector(): string {
        return $this->accountingConnector;
    }

    public function setAccountingConnector(string $accountingConnector): void {
        $this->accountingConnector = $accountingConnector;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

