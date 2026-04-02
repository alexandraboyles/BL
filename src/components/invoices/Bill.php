<?php
namespace Invoices;

use Core\BaseModel;

class Bill extends BaseModel {
    private int $supplierId;
    private $invoiceId;
    private int $manifestId;

    public function __construct($supplierId, $invoiceId, $manifestId) {
        parent::__construct();
        $this->supplierId = $supplierId;
        $this->invoiceId = $invoiceId;
        $this->manifestId = $manifestId;
    }

    public function getSupplierId(): int {
        return $this->supplierId;
    }

    public function setSupplierId(int $supplierId): void {
        $this->supplierId = $supplierId;
    }

    public function getInvoiceId() {
        return $this->invoiceId;
    }

    public function setInvoiceId($invoiceId): void {
        $this->invoiceId = $invoiceId;
    }

    public function getManifestId(): int {
        return $this->manifestId;
    }

    public function setManifestId(int $manifestId): void {
        $this->manifestId = $manifestId;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

