<?php
namespace Addresses;

use Core\Validator;
use Core\BaseModel;

class Address extends BaseModel {
    public int $addressId;
    public string $street_1;
    public string $street_2;
    public string $suburb;
    public string $state;
    public string $postcode;

    public function __construct($addressId, $street_1, $street_2, $suburb, $state, $postcode) {
        parent::__construct();
        $this->addressId = $addressId;
        $this->street_1 = Validator::isString($street_1, "Street_1");
        $this->street_2 = Validator::isString($street_2, "Street_2");
        $this->suburb = Validator::isString($suburb, "Suburb");
        $this->state = Validator::isString($state, "State");
        $this->postcode = Validator::isString($postcode, "Postcode");
    }
}
