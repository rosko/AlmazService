<?php

/*
 High level model class.
 Current class describe the resource type 
*/

require_once(dirname(__FILE__) . '/DataModel.php');

class Object extends DataModel
{
    public $name;
    
    public $text_value;
    
    public $descr;
    
    /* Property description list associated with Object */
    public $property = array();
    
    public function __construct() {
    }
    
    public function __toString() {
        return "Object";
    }
    
    public function getAttributes() {
        $attr = parent::getAttributes();
        
        $props = array();
        foreach ($this->property as $property) {
            $props[] = $property->getAttributes();
        }
        unset($attr['property']);
        $attr['property'] = $props;
        
        return $attr;
    }
    
    public function setAttributes($attr) {
        parent::setAttributes($attr);
        
        $props = $attr['property'];
        if (isset($props) && is_array($props)) {
            foreach ($props as $propertyAttr) {
                $property = new Property();
                $property->setAttributes($propertyAttr);
                $this->property[] = $property;
            }
        }
    }
    
    public function getFields() {
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'name', 'label'=>'Name', 'type'=>'string');
        $fields[] = array('attribute'=>'text_value', 'label'=>'Value', 'type'=>'text');
        $fields[] = array('attribute'=>'descr', 'label'=>'Description', 'type'=>'string');
        $fields[] = array('attribute'=>'property', 'label'=>'Properties', 'type'=>'array');
        return $fields;
    }
}