<?php
namespace Transport;

use Core\BaseModel;
use Core\Validator;

class Consignment extends BaseModel {
    private int $consignmentId;
    private $saleOrderId;
    private $addressId;
    private $productId;
    private $deliveryRunId;
    private $driverId;
    private int $runsheetId;
    private string $service;
    private string $reference;
    private bool $is_residential;
    private int $quantity;
    private float $cubic;
    private float $weight;
    private float $pallets;
    private float $spaces;

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
