<?php
namespace Warehouse;

use Core\Validator;
use Core\BaseModel;

class PurchaseOrder extends BaseModel {
    public int $purchaseOrderId;
    public $customerId;
    public string $orderReference;
    public string $custReference;
    public string $shipName;
    public string $shipAddress;
    public $orderDate;
    public $lineItems;
    public string $status;

    public function __construct($purchaseOrderId, $customerId, $orderReference, $custReference, $shipName, $shipAddress, $orderDate, $lineItems, $status) {
        parent::__construct();
        $this->purchaseOrderId = $purchaseOrderId;
        $this->customerId = $customerId;
        $this->orderReference = Validator::isString($orderReference, "Order Reference");
        $this->custReference = Validator::isString($custReference, "Cust Reference");
        $this->shipName = Validator::isString($shipName, "Ship Name");
        $this->shipAddress = Validator::isString($shipAddress, "Ship Address");
        $this->orderDate = date('Y-m-d H:i:s');
        $this->lineItems = $lineItems;
        $this->status = Validator::isString($status, "Status");
    }
}
