<?php
namespace TransportSettings;

use Core\BaseModel;

class CustomField extends BaseModel {
    public $name;
    public $shortName;
    public $fieldType;
    public $mappedFieldName;
    public $fieldMapping;

    public function __construct($name, $shortName, $fieldType, $mappedFieldName, $fieldMapping) {
        parent::__construct();
        $this->name = $name;
        $this->shortName = $shortName;
        $this->fieldType = $fieldType;
        $this->mappedFieldName = $mappedFieldName;
        $this->fieldMapping = $fieldMapping;
    }
}
