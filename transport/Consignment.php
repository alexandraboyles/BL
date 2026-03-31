<?php
namespace Transport;

use Core\BaseModel;
use Core\Validator;

class Consignment extends BaseModel {
    public $consignmentId;
    public $saleOrderId;
    public $addressId;
    public $productId;
    public $deliveryRunId;
    public $driverId;
    public $runsheetId;
    public $service;
    public $reference;
    public $is_residential;
    public $quantity;
    public $cubic;
    public $weight;
    public $pallets;
    public $spaces;

    public function __construct($consignmentId, $saleOrderId, $addressId, $productId, $deliveryRunId, $driverId, $runsheetId, $service, $reference, $is_residential, $quantity, $cubic, $weight, $pallets, $spaces) {
        parent::__construct();

        $this->quantity = Validator::positiveNumber($quantity, "Quantity");
        $this->weight   = Validator::positiveNumber($weight, "Weight");

        $this->consignmentId = $consignmentId;
        $this->saleOrderId = $saleOrderId;
        $this->addressId = $addressId;
        $this->productId = $productId;
        $this->deliveryRunId = $deliveryRunId;
        $this->driverId = $driverId;
        $this->runsheetId = $runsheetId;
        $this->service = $service;
        $this->reference = $reference;
        $this->is_residential = $is_residential;
        $this->cubic = $cubic;
        $this->pallets = $pallets;
        $this->spaces = $spaces;
    }
}
