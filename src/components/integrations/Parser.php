<?php
namespace Integrations;

use Core\BaseModel;

class Parser extends BaseModel {
    private $customerId;
    private string $name;
    private string $className;
    private string $class;
    private string $type;
    private $acceptedFiletypes;
    private string $toAddress;

    public function __construct($customerId, $name, $className, $class, $type, $acceptedFiletypes, $toAddress) {
        parent::__construct();
        $this->customerId = $customerId;
        $this->name = $name;
        $this->className = $className;
        $this->class = $class;
        $this->type = $type;
        $this->acceptedFiletypes = $acceptedFiletypes;
        $this->toAddress = $toAddress;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function setCustomerId($customerId): void {
        $this->customerId = $customerId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getClassName(): string {
        return $this->className;
    }

    public function setClassName(string $className): void {
        $this->className = $className;
    }

    public function getClass(): string {
        return $this->class;
    }

    public function setClass(string $class): void {
        $this->class = $class;
    }

    public function getType(): string {
        return $this->type;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function getAcceptedFiletypes() {
        return $this->acceptedFiletypes;
    }

    public function setAcceptedFiletypes($acceptedFiletypes): void {
        $this->acceptedFiletypes = $acceptedFiletypes;
    }

    public function getToAddress(): string {
        return $this->toAddress;
    }

    public function setToAddress(string $toAddress): void {
        $this->toAddress = $toAddress;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

