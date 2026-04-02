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

    public function getAddressId(): int {
        return $this->addressId;
    }

    public function setAddressId(int $addressId): void {
        $this->addressId = $addressId;
    }

    public function getStreet_1(): string {
        return $this->street_1;
    }

    public function getStreet1(): string {
        return $this->street_1;
    }

    public function setStreet_1(string $street_1): void {
        $this->street_1 = $street_1;
    }

    public function getStreet_2(): string {
        return $this->street_2;
    }

    public function getStreet2(): string {
        return $this->street_2;
    }

    public function setStreet_2(string $street_2): void {
        $this->street_2 = $street_2;
    }

    public function getSuburb(): string {
        return $this->suburb;
    }

    public function setSuburb(string $suburb): void {
        $this->suburb = $suburb;
    }

    public function getState(): string {
        return $this->state;
    }

    public function setState(string $state): void {
        $this->state = $state;
    }

    public function getPostcode(): string {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): void {
        $this->postcode = $postcode;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

