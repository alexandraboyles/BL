<?php
namespace Warehouse;

use Core\Validator;
use Core\BaseModel;

class PurchaseOrder extends BaseModel {
    private int $purchaseOrderId;
    private $customerId;
    private string $orderReference;
    private string $custReference;
    private string $shipName;
    private string $shipAddress;
    private $orderDate;
    private $lineItems;
    private string $status;

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
