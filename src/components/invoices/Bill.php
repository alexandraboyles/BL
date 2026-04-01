<?php
namespace Invoices;

use Core\BaseModel;

class Bill extends BaseModel {
    public int $supplierId;
    public $invoiceId;
    public int $manifestId;

    public function __construct($supplierId, $invoiceId, $manifestId) {
        parent::__construct();
        $this->supplierId = $supplierId;
        $this->invoiceId = $invoiceId;
        $this->manifestId = $manifestId;
    }
}
