<?php
namespace Contacts;

use Core\BaseModel;

class Supplier extends BaseModel {
    public $rateCardId;
    public $companyName;
    public $email;
    public $telNo;
    public $accountingConnector;

    public function __construct($rateCardId, $companyName, $email, $telNo, $accountingConnector) {
        parent::__construct();
        $this->rateCardId = $rateCardId;
        $this->companyName = $companyName;
        $this->email = $email;
        $this->telNo = $telNo;
        $this->accountingConnector = $accountingConnector;
    }
}
