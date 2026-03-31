<?php
namespace Addresses;

use Core\BaseModel;

class AddressToInvoiceCustomerMapping extends BaseModel {
    public $id;
    public $customerId;
    public $addressId;

    public function __construct($id, $customerId, $addressId) {
        parent::__construct();
        $this->id = $id;
        $this->customerId = $customerId;
        $this->addressId = $addressId;
    }
}
