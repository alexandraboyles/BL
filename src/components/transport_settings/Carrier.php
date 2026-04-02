<?php
namespace TransportSettings;

use Core\BaseModel;

class Carrier extends BaseModel {
    private string $name;
    private bool $on_forwarder;
    private string $status;

    public function __construct($name, $on_forwarder, $status) {
        parent::__construct();
        $this->name = $name;
        $this->on_forwarder = $on_forwarder;
        $this->status = $status;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getOn_forwarder(): bool {
        return $this->on_forwarder;
    }

    public function getOnForwarder(): bool {
        return $this->on_forwarder;
    }

    public function setOn_forwarder(bool $on_forwarder): void {
        $this->on_forwarder = $on_forwarder;
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

