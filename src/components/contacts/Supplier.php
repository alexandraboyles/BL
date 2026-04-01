<?php
namespace Contacts;

use Core\BaseModel;

class Supplier extends BaseModel {
    public int $rateCardId;
    public string $companyName;
    public string $email;
    public string $telNo;
    public string $accountingConnector;

    public function __construct($rateCardId, $companyName, $email, $telNo, $accountingConnector) {
        parent::__construct();
        $this->rateCardId = $rateCardId;
        $this->companyName = $companyName;
        $this->email = $email;
        $this->telNo = $telNo;
        $this->accountingConnector = $accountingConnector;
    }
}
