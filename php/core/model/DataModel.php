<?php

class DataModel
{
    const INVALID_ID = 0;
    
    /* ResourceType object id */
    public $id = DataModel::INVALID_ID;
    
    public function getAttributes() {
        return get_object_vars($this);
    }
    
    public function setAttributes($attr) {
        if (is_array($attr)) {
            foreach ($attr as $property => $value) {
                if (!is_array($value)) {
                    $this->{$property} = $value;
                }
            }
        }
    }
    
    public function getFields() {
        return array(
            array(
                'attribute'=>'id', 'label'=>'ID', 'type'=>'integer', 'readonly'=>true
            ),
        );
    }
}