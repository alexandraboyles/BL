<?php
namespace Warehouse;

use Core\BaseModel;

class SalesOrder extends BaseModel {
    private int $salesOrderId;
    private $customerId;
    private string $orderReference;
    private string $custReference;
    private string $shipName;
    private string $shipAddress;
    private $orderDate;
    private $lineItems;
    private string $orderStatus;
    private string $shipInstructions;
    private string $trackingCarrier;
    private string $trackingNumber;
    private string $shipMethod;
    private bool $is_urgent;
    private bool $is_invoiced;
    private string $packer;
    private $history;
    private $charges;
    private $consignments;
    private $errors;

    public function __construct($salesOrderId, $customerId, $orderReference, $custReference, $shipName, $shipAddress, $orderDate, $lineItems, $orderStatus, $shipInstructions, $trackingCarrier, $trackingNumber, $shipMethod, $is_urgent, $is_invoiced, $packer, $history, $charges, $consignments, $errors) {
        parent::__construct();
        $this->salesOrderId = $salesOrderId;
        $this->customerId = $customerId;
        $this->orderReference = $orderReference;
        $this->custReference = $custReference;
        $this->shipName = $shipName;
        $this->shipAddress = $shipAddress;
        $this->orderDate = date('Y-m-d H:i:s');
        $this->lineItems = $lineItems;
        $this->orderStatus = $orderStatus;
        $this->shipInstructions = $shipInstructions;
        $this->trackingCarrier = $trackingCarrier;
        $this->trackingNumber = $trackingNumber;
        $this->shipMethod = $shipMethod;
        $this->is_urgent = $is_urgent;
        $this->is_invoiced = $is_invoiced;
        $this->packer = $packer;
        $this->history = $history;
        $this->charges = $charges;
        $this->consignments = $consignments;
        $this->errors = $errors;
    }

    public function getSalesOrderId(): int {
        return $this->salesOrderId;
    }

    public function setSalesOrderId(int $salesOrderId): void {
        $this->salesOrderId = $salesOrderId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getOrderReference(): string {
        return $this->orderReference;
    }

    public function setOrderReference(string $orderReference): void {
        $this->orderReference = $orderReference;
    }

    public function getCustReference(): string {
        return $this->custReference;
    }

    public function setCustReference(string $custReference): void {
        $this->custReference = $custReference;
    }

    public function getShipName(): string {
        return $this->shipName;
    }

    public function setShipName(string $shipName): void {
        $this->shipName = $shipName;
    }

    public function getShipAddress(): string {
        return $this->shipAddress;
    }

    public function setShipAddress(string $shipAddress): void {
        $this->shipAddress = $shipAddress;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function setOrderDate($orderDate): void {
        $this->orderDate = $orderDate;
    }

    public function getLineItems() {
        return $this->lineItems;
    }

    public function setLineItems($lineItems): void {
        $this->lineItems = $lineItems;
    }

    public function getOrderStatus(): string {
        return $this->orderStatus;
    }

    public function setOrderStatus(string $orderStatus): void {
        $this->orderStatus = $orderStatus;
    }

    public function getShipInstructions(): string {
        return $this->shipInstructions;
    }

    public function setShipInstructions(string $shipInstructions): void {
        $this->shipInstructions = $shipInstructions;
    }

    public function getTrackingCarrier(): string {
        return $this->trackingCarrier;
    }

    public function setTrackingCarrier(string $trackingCarrier): void {
        $this->trackingCarrier = $trackingCarrier;
    }

    public function getTrackingNumber(): string {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(string $trackingNumber): void {
        $this->trackingNumber = $trackingNumber;
    }

    public function getShipMethod(): string {
        return $this->shipMethod;
    }

    public function setShipMethod(string $shipMethod): void {
        $this->shipMethod = $shipMethod;
    }

    public function getIsUrgent(): bool {
        return $this->is_urgent;
    }

    public function setIs_urgent(bool $is_urgent): void {
        $this->is_urgent = $is_urgent;
    }

    public function getIsInvoiced(): bool {
        return $this->is_invoiced;
    }

    public function setIs_invoiced(bool $is_invoiced): void {
        $this->is_invoiced = $is_invoiced;
    }

    public function getPacker(): string {
        return $this->packer;
    }

    public function setPacker(string $packer): void {
        $this->packer = $packer;
    }

    public function getHistory() {
        return $this->history;
    }

    public function setHistory($history): void {
        $this->history = $history;
    }

    public function getCharges() {
        return $this->charges;
    }

    public function setCharges($charges): void {
        $this->charges = $charges;
    }

    public function getConsignments() {
        return $this->consignments;
    }

    public function setConsignments($consignments): void {
        $this->consignments = $consignments;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function setErrors($errors): void {
        $this->errors = $errors;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

