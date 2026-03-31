<?php
namespace Invoices;

use Core\BaseModel;

class Bill extends BaseModel {
    public $supplierId;
    public $invoiceId;
    public $manifestId;

    public function __construct($supplierId, $invoiceId, $manifestId) {
        parent::__construct();
        $this->supplierId = $supplierId;
        $this->invoiceId = $invoiceId;
        $this->manifestId = $manifestId;
    }
}
