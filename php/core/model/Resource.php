<?php

/*
 High level model class.
 Current class describe the resource type meta
*/

require_once(dirname(__FILE__) . '/DataModel.php');
require_once(dirname(__FILE__) . '/Property.php');

class Resource extends DataModel
{
    /* ResourceTypeMeta description */
    private $descr;
    
    private $create_date;
    
    private $modify_date;
    
    private $owner_user;
    
    public $type;
    
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
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'descr', 'label'=>'Description', 'type'=>'string');
        $fields[] = array('attribute'=>'create_date', 'label'=>'Creation Date', 'type'=>'string');
        $fields[] = array('attribute'=>'modify_date', 'label'=>'Modify Date', 'type'=>'string');
        $fields[] = array('attribute'=>'owner_user', 'label'=>'Owner User', 'type'=>'string');
        $fields[] = array('attribute'=>'property', 'label'=>'Property', 'type'=>'array');
        return $fields;
    }
}