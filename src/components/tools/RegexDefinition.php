<?php
namespace Tools;

use Core\BaseModel;

class RegexDefinition extends BaseModel {
    private string $name;
    private string $regex;
    private string $status;

    public function __construct($name, $regex, $status) {
        parent::__construct();
        $this->name = $name;
        $this->regex = $regex;
        $this->status = $status;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getRegex(): string {
        return $this->regex;
    }

    public function setRegex(string $regex): void {
        $this->regex = $regex;
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

