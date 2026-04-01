<?php
namespace Invoices;

use Core\BaseModel;

class RateCard extends BaseModel {
    public $customerId;
    public $rates;
    public string $contact_email;

    public function __construct($customerId, $rates, $contact_email) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->rates = $rates;
        $this->contact_email = $contact_email;
    }
}
