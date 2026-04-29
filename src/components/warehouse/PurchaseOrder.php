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

    public function getPurchaseOrderId(): int {
        return $this->purchaseOrderId;
    }

    public function setPurchaseOrderId(int $purchaseOrderId): void {
        $this->purchaseOrderId = $purchaseOrderId;
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

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

