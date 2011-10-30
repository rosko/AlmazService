<?php

include_once 'database/DatabaseTable.php';

class DatabaseRecord {
    const INVALID_RECORD_ID = -1;
        
    private $table = null;
    private $values = array();
    private $id = INVALID_RECORD_ID;
    
    protected function __construct($tableName, $id) {
        $this->table = DatabaseTable::getTableWithName($tableName);
        $this->id = $id;
    }
    
    public function __set($property, $value) {
        if (!isset($this->table))
            throw new Exception( '*** DatabaseRecord: Invalid record table');
        
        if (strcmp($property, 'id') == 0) {
            $this->setId($value);
            return;
        }
        
        foreach ($this->table->getFields() as $name) {
            if (strcmp($name, $property) == 0) {
                $fieldValue = $this->values[$property];
                if ($fieldValue) {
                    if ($fieldValue->value != $value) {
                        $fieldValue->value = $value;
                        $fieldValue->modifyFlag = true;
                    }
                } else {
                    $this->values[$property] = new DatabaseRecordFieldValue($value, true);
                }
                break;
            }
        }
    }
    
    public function __get($property) {
        if (!isset($this->table))
            throw new Exception('*** DatabaseRecord: Invalid record table');
        
        if (strcmp($property, 'id') == 0)
            return $this->getId();
        
        foreach ($this->values as $name => $fieldValue) {
            if (strcmp($name, $property) == 0)
                return $fieldValue->value;
        }
    }
    
    public function __toString() {
        $str = 'DatabaseRecord: [';
        foreach ($this->values as $val) {
            $str .= '{' . $val . '}';
        }
        $str .= ']<br>';
        return $str;
    }
    
    public function setId($id) {
        if (!$this->isNewRecord())
            throw new Exception('*** DatabaseRecord: Record already inserted');
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getTable() {
        return $this->table;
    }
    
    public function resetModifyFlag() {
        foreach ($this->values as $name => $fieldValue) {
            $fieldValue->modifyFlag = false;
        }
    }
    
    public function isNewRecord() {
        return ($this->getId() == DatabaseRecord::INVALID_RECORD_ID);
    }
    
    public function isFieldModified($fieldName) {
        if (!isset($this->table))
            throw new Exception('*** DatabaseRecord: Invalid record table');
        
        $fieldValue = $this->values[$fieldName];
        if (!isset($fieldValue))
            return false;
        return $fieldValue->modifyFlag;
    }
}

class DatabaseRecordFieldValue {
    public $value;
    public $modifyFlag;
    
    public function __construct($value, $modifyFlag) {
        $this->value = $value;
        $this->modifyFlag = $modifyFlag;
    }
    
    public function __toString() {
        return 'Value: '.$this->value.', Modify: '.$this->modifyFlag;
    }
}

?>