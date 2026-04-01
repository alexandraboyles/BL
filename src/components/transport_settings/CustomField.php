<?php
namespace TransportSettings;

use Core\BaseModel;

class CustomField extends BaseModel {
    public string $name;
    public string $shortName;
    public string $fieldType;
    public string $mappedFieldName;
    public string $fieldMapping;

    public function __construct($name, $shortName, $fieldType, $mappedFieldName, $fieldMapping) {
        parent::__construct();
        $this->name = $name;
        $this->shortName = $shortName;
        $this->fieldType = $fieldType;
        $this->mappedFieldName = $mappedFieldName;
        $this->fieldMapping = $fieldMapping;
    }
}
