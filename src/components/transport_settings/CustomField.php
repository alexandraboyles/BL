<?php
namespace TransportSettings;

use Core\BaseModel;

class CustomField extends BaseModel {
    private string $name;
    private string $shortName;
    private string $fieldType;
    private string $mappedFieldName;
    private string $fieldMapping;

    public function __construct($name, $shortName, $fieldType, $mappedFieldName, $fieldMapping) {
        parent::__construct();
        $this->name = $name;
        $this->shortName = $shortName;
        $this->fieldType = $fieldType;
        $this->mappedFieldName = $mappedFieldName;
        $this->fieldMapping = $fieldMapping;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getShortName(): string {
        return $this->shortName;
    }

    public function setShortName(string $shortName): void {
        $this->shortName = $shortName;
    }

    public function getFieldType(): string {
        return $this->fieldType;
    }

    public function setFieldType(string $fieldType): void {
        $this->fieldType = $fieldType;
    }

    public function getMappedFieldName(): string {
        return $this->mappedFieldName;
    }

    public function setMappedFieldName(string $mappedFieldName): void {
        $this->mappedFieldName = $mappedFieldName;
    }

    public function getFieldMapping(): string {
        return $this->fieldMapping;
    }

    public function setFieldMapping(string $fieldMapping): void {
        $this->fieldMapping = $fieldMapping;
    }

    public function toArray() {
        $vars = get_object_vars($this);
        $vars['id'] = $this->getId();
        return $vars;
    }
}

