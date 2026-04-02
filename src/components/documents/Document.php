<?php
namespace Documents;

use Core\BaseModel;

class Document extends BaseModel {
    private $saleOrderId;
    private $customerId;
    private $consignmentId;
    private string $fileType;

    public function __construct($saleOrderId, $customerId, $consignmentId, $fileType) {
        parent::__construct();
        $this->saleOrderId = $saleOrderId;
        $this->customerId = $customerId;
        $this->consignmentId = $consignmentId;
        $this->fileType = $fileType;
    }

    public function getSaleOrderId() {
        return $this->saleOrderId;
    }

    public function setSaleOrderId($saleOrderId): void {
        $this->saleOrderId = $saleOrderId;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getConsignmentId() {
        return $this->consignmentId;
    }

    public function setConsignmentId($consignmentId): void {
        $this->consignmentId = $consignmentId;
    }

    public function getFileType(): string {
        return $this->fileType;
    }

    public function setFileType(string $fileType): void {
        $this->fileType = $fileType;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

