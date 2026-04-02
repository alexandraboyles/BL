<?php
namespace Warehouse;

use Core\BaseModel;

class Container extends BaseModel {
    private $customerId;
    private string $containerNumber;
    private $containerArrivalDate;
    private $containerDepartureDate;
    private string $transportContact;
    private string $clientName;
    private string $containerSize;
    private string $shipment;
    private string $comments;
    private $dateCreated;
    private $dateModified;

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

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getContainerNumber(): string {
        return $this->containerNumber;
    }

    public function setContainerNumber(string $containerNumber): void {
        $this->containerNumber = $containerNumber;
    }

    public function getContainerArrivalDate() {
        return $this->containerArrivalDate;
    }

    public function setContainerArrivalDate($containerArrivalDate): void {
        $this->containerArrivalDate = $containerArrivalDate;
    }

    public function getContainerDepartureDate() {
        return $this->containerDepartureDate;
    }

    public function setContainerDepartureDate($containerDepartureDate): void {
        $this->containerDepartureDate = $containerDepartureDate;
    }

    public function getTransportContact(): string {
        return $this->transportContact;
    }

    public function setTransportContact(string $transportContact): void {
        $this->transportContact = $transportContact;
    }

    public function getClientName(): string {
        return $this->clientName;
    }

    public function setClientName(string $clientName): void {
        $this->clientName = $clientName;
    }

    public function getContainerSize(): string {
        return $this->containerSize;
    }

    public function setContainerSize(string $containerSize): void {
        $this->containerSize = $containerSize;
    }

    public function getShipment(): string {
        return $this->shipment;
    }

    public function setShipment(string $shipment): void {
        $this->shipment = $shipment;
    }

    public function getComments(): string {
        return $this->comments;
    }

    public function setComments(string $comments): void {
        $this->comments = $comments;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated): void {
        $this->dateCreated = $dateCreated;
    }

    public function getDateModified() {
        return $this->dateModified;
    }

    public function setDateModified($dateModified): void {
        $this->dateModified = $dateModified;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

