<?php

/*
 High level model class.
 Current class describe the resource type meta
*/

require_once(dirname(__FILE__) . '/DataModel.php');

class Property extends DataModel
{
    /* ResourceTypeMeta name */
    public $key_name;
    
    /* ResourceTypeMeta description */
    public $descr;
    
    
    /* Methods */
    public function __construct() {
    }
    
    public function __toString() {
        return "Property";
    }
    
    public function getAttributes() {
        $attr = parent::getAttributes();
        $attr['key_name'] = $this->key_name;
        $attr['descr'] = $this->descr;
        return $attr;
    }
    
    public function setAttributes($attr) {
        parent::setAttributes($attr);
        $this->key_name = $attr['key_name'];
        $this->descr = $attr['descr'];
    }
    
    public function getFields() {
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'key_name', 'label'=>'Name', 'type'=>'string');
        $fields[] = array('attribute'=>'descr', 'label'=>'Description', 'type'=>'string');
        return $fields;
    }
}