<?php

/*
 High level model class.
 Current class describe the resource type 
*/

require_once(dirname(__FILE__) . '/DataModel.php');
require_once(dirname(__FILE__) . '/Property.php');

class ClassName extends DataModel
{
    /* Name of the ResourceType */
    public $name;
    
    /* ResourceType description */
    public $descr;
    
    /* Property description list associated with ResourceType */
    public $property = array();
    
    // /* Objects description associated with ResourceType */
    public $objects = array();
    
    public function __toString() {
        return $this->description;
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
                $property = new Property;
                $property->setAttributes($propertyAttr);
                $this->property[] = $property;
            }
        }
    }
    
    public function getFields() {
        return array(
            array('attribute'=>'name', 'label'=>'Name', 'type'=>'string'),
            array('attribute'=>'descr', 'label'=>'Description', 'type'=>'string'),
            array('attribute'=>'property', 'label'=>'Properties', 'type'=>'array'),
        );
    }
}
