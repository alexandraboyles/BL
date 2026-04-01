<?php
namespace Addresses;

use Core\BaseModel;

class AddressString extends BaseModel {
    public $customerId;
    public $addressId;
    public string $text;

    public function __construct($customerId, $addressId, $text) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->addressId = $addressId;
        $this->text = $text;
    }
}
