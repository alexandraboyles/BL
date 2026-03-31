<?php
namespace Addresses;

use Core\BaseModel;

class AddressString extends BaseModel {
    public $id;
    public $customerId;
    public $addressId;
    public $text;

    public function __construct($id, $customerId, $addressId, $text) {
        parent::__construct();
        $this->id = $id;
        $this->customerId = $customerId;
        $this->addressId = $addressId;
        $this->text = $text;
    }
}
