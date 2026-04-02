<?php
namespace Invoices;

use Core\BaseModel;

class RateCard extends BaseModel {
    private $customerId;
    private $rates;
    private string $contact_email;

    public function __construct($customerId, $rates, $contact_email) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->rates = $rates;
        $this->contact_email = $contact_email;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getRates() {
        return $this->rates;
    }

    public function setRates($rates): void {
        $this->rates = $rates;
    }

    public function getContact_email(): string {
        return $this->contact_email;
    }

    public function getContactEmail(): string {
        return $this->contact_email;
    }

    public function setContact_email(string $contact_email): void {
        $this->contact_email = $contact_email;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

