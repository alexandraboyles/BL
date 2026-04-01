<?php
namespace Transport;

use Core\BaseModel;
use Core\Validator;

class Consignment extends BaseModel {
    public int $consignmentId;
    public $saleOrderId;
    public $addressId;
    public $productId;
    public $deliveryRunId;
    public $driverId;
    public int $runsheetId;
    public string $service;
    public string $reference;
    public bool $is_residential;
    public int $quantity;
    public float $cubic;
    public float $weight;
    public float $pallets;
    public float $spaces;

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
        $this->service = Validator::isString($service, "Service");
        $this->reference = Validator::isString($reference, "Reference");
        $this->is_residential = $is_residential;
        $this->cubic = $cubic;
        $this->pallets = $pallets;
        $this->spaces = $spaces;
    }
}
