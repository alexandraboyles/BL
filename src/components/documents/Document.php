<?php
namespace Documents;

use Core\BaseModel;

class Document extends BaseModel {
    public $saleOrderId;
    public $customerId;
    public $consignmentId;
    public string $fileType;

    public function __construct($saleOrderId, $customerId, $consignmentId, $fileType) {
        parent::__construct();
        $this->saleOrderId = $saleOrderId;
        $this->customerId = $customerId;
        $this->consignmentId = $consignmentId;
        $this->fileType = $fileType;
    }
}
