<?php
namespace Addresses;

use Core\BaseModel;

class AddressToInvoiceCustomerMapping extends BaseModel {
    public $customerId;
    public $addressId;

    public function __construct($customerId, $addressId) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->addressId = $addressId;
    }
}
