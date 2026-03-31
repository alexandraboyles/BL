<?php
namespace Addresses;

use Core\BaseModel;

class Address extends BaseModel {
    public $addressId;
    public $street_1;
    public $street_2;
    public $suburb;
    public $state;
    public $postcode;

    public function __construct($addressId, $street_1, $street_2, $suburb, $state, $postcode) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->street_1 = $street_1;
        $this->street_2 = $street_2;
        $this->suburb = $suburb;
        $this->state = $state;
        $this->postcode = $postcode;
    }
}
