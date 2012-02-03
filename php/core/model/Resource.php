<?php

/*
 High level model class.
 Current class describe the resource type meta
*/

require_once(dirname(__FILE__) . '/DataModel.php');

class Resource extends DataModel
{
    /* ResourceTypeMeta description */
    private $descr;
    
    /* Property description list associated with ResourceType */
    private $property = array();
    
    /* Objects description associated with ResourceType */
    private $objects = array();
    
    
    /* Methods */
    public function __construct() {
    }
    
    public function __toString() {
        return $this->descr;
    }
    
    public function getAttributes() {
        $attr = parent::getAttributes();
        $attr['name'] = $this->name;
        $attr['descr'] = $this->descr;
        return $attr;
    }
    
    public function setAttributes($attr) {
        parent::setAttributes($attr);
        $this->name = $attr['key_name'];
        $this->descr = $attr['descr'];
    }
}