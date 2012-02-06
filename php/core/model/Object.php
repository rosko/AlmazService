<?php

/*
 High level model class.
 Current class describe the resource type 
*/

require_once(dirname(__FILE__) . '/DataModel.php');

class Object extends DataModel
{
    public function __construct() {
    }
    
    public function getAttributes() {
        $attr = parent::getAttributes();
        
        return $attr;
    }
    
    public function setAttributes($attr) {
        
    }
    
    public function getFields() {
        $fields = parent::getFields();
//        $fields[] = array('attribute'=>'key_name', 'label'=>'Name', 'type'=>'string');
        return $fields;
    }
}