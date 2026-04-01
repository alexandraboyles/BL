<?php
namespace Addresses;

use Core\Validator;
use Core\BaseModel;

class Address extends BaseModel {
    private int $addressId;
    private string $street_1;
    private string $street_2;
    private string $suburb;
    private string $state;
    private string $postcode;

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
