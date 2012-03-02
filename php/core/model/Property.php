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
    
    /* Property value */
    public $value;
    
    public function __toString() {
        return "Property";
    }
    
    public function getFields() {
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'key_name', 'label'=>'Name', 'type'=>'string');
        $fields[] = array('attribute'=>'descr', 'label'=>'Description', 'type'=>'string');
        return $fields;
    }
}