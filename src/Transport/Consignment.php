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

    public function getConsignmentId(): int {
        return $this->consignmentId;
    }

    public function setConsignmentId(int $consignmentId): void {
        $this->consignmentId = $consignmentId;
    }

    public function getSaleOrderId() {
        return $this->saleOrderId;
    }

    public function setSaleOrderId($saleOrderId): void {
        $this->saleOrderId = $saleOrderId;
    }

    public function getAddressId() {
        return $this->addressId;
    }

    public function setAddressId($addressId): void {
        $this->addressId = $addressId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId): void {
        $this->productId = $productId;
    }

    public function getDeliveryRunId() {
        return $this->deliveryRunId;
    }

    public function setDeliveryRunId($deliveryRunId): void {
        $this->deliveryRunId = $deliveryRunId;
    }

    public function getDriverId() {
        return $this->driverId;
    }

    public function setDriverId($driverId): void {
        $this->driverId = $driverId;
    }

    public function getRunsheetId(): int {
        return $this->runsheetId;
    }

    public function setRunsheetId(int $runsheetId): void {
        $this->runsheetId = $runsheetId;
    }

    public function getService(): string {
        return $this->service;
    }

    public function setService(string $service): void {
        $this->service = $service;
    }

    public function getReference(): string {
        return $this->reference;
    }

    public function setReference(string $reference): void {
        $this->reference = $reference;
    }

    public function getIs_residential(): bool {
        return $this->is_residential;
    }

    public function getIsResidential(): bool {
        return $this->is_residential;
    }

    public function setIs_residential(bool $is_residential): void {
        $this->is_residential = $is_residential;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getCubic(): float {
        return $this->cubic;
    }

    public function setCubic(float $cubic): void {
        $this->cubic = $cubic;
    }

    public function getWeight(): float {
        return $this->weight;
    }

    public function setWeight(float $weight): void {
        $this->weight = $weight;
    }

    public function getPallets(): float {
        return $this->pallets;
    }

    public function setPallets(float $pallets): void {
        $this->pallets = $pallets;
    }

    public function getSpaces(): float {
        return $this->spaces;
    }

    public function setSpaces(float $spaces): void {
        $this->spaces = $spaces;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

