<?php
namespace Warehouse;

use Core\BaseModel;

class Container extends BaseModel {
    public $customerId;
    public string $containerNumber;
    public $containerArrivalDate;
    public $containerDepartureDate;
    public string $transportContact;
    public string $clientName;
    public string $containerSize;
    public string $shipment;
    public string $comments;
    public $dateCreated;
    public $dateModified;

    public function __construct($customerId, $containerNumber, $containerArrivalDate, $containerDepartureDate, $transportContact, $clientName, $containerSize, $shipment, $comments, $dateCreated, $dateModified) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->containerNumber = $containerNumber;
        $this->containerArrivalDate = $containerArrivalDate;
        $this->containerDepartureDate = $containerDepartureDate;
        $this->transportContact = $transportContact;
        $this->clientName = $clientName;
        $this->containerSize = $containerSize;
        $this->shipment = $shipment;
        $this->comments = $comments;
        $this->dateCreated = date('Y-m-d H:i:s');
        $this->dateModified = date('Y-m-d H:i:s');
    }
}
