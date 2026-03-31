<?php
namespace Warehouse;

use Core\BaseModel;

class PurchaseOrder extends BaseModel {
    public $purchaseOrderId;
    public $customerId;
    public $orderReference;
    public $custReference;
    public $shipName;
    public $shipAddress;
    public $orderDate;
    public $lineItems;
    public $status;

    public function __construct($purchaseOrderId, $customerId, $orderReference, $custReference, $shipName, $shipAddress, $orderDate, $lineItems, $status) {
        parent::__construct();
        $this->purchaseOrderId = $purchaseOrderId;
        $this->customerId = $customerId;
        $this->orderReference = $orderReference;
        $this->custReference = $custReference;
        $this->shipName = $shipName;
        $this->shipAddress = $shipAddress;
        $this->orderDate = $orderDate;
        $this->lineItems = $lineItems;
        $this->status = $status;
    }
}
