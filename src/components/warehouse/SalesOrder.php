<?php
namespace Warehouse;

use Core\BaseModel;

class SalesOrder extends BaseModel {
    public int $salesOrderId;
    public $customerId;
    public string $orderReference;
    public string $custReference;
    public string $shipName;
    public string $shipAddress;
    public $orderDate;
    public $lineItems;
    public string $orderStatus;
    public string $shipInstructions;
    public string $trackingCarrier;
    public string $trackingNumber;
    public string $shipMethod;
    public bool $is_urgent;
    public bool $is_invoiced;
    public string $packer;
    public $history;
    public $charges;
    public $consignments;
    public $errors;

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
}
