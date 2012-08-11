<?php

/*
 High level model class.
 Current class describe the resource type meta
*/

require_once(dirname(__FILE__) . '/DataModel.php');
require_once(dirname(__FILE__) . '/Property.php');
require_once(dirname(__FILE__) . '/Object.php');

class Resource extends DataModel
{
    /* ResourceTypeMeta name */
    public $name;
    
    public $create_date;
    
    public $modify_date;
    
    public $owner_user;
    
    public $type;
    
    /* Property description list associated with ResourceType */
    public $property = array();
    
    /* Objects description associated with ResourceType */
    public $objects = array();
    
    
    /* Methods */
    public function __construct() {
    }
    
    public function __toString() {
        return $this->descr;
    }
    
    public function getPropertyByName($name) {
        foreach ($this->property as $property) {
            if ($property->key_name == $name)
                return $property;
        }
    }
    
    public function getAttributes() {
        $attr = parent::getAttributes();
        
        // Add properties attributes
        $props = array();
        foreach ($this->property as $property) {
            $props[] = $property->getAttributes();
        }
        unset($attr['property']);
        $attr['property'] = $props;
        
        //Add object attributes
        $objects = array();
        foreach ($this->objects as $object) {
            $objects[] = $object->getAttributes();
        }
        unset($attr['objects']);
        $attr['objects'] = $objects;
        
        return $attr;
    }
    
    public function setAttributes($attr) {
        parent::setAttributes($attr);

        if (isset($attr['property']) && is_array($attr['property'])) {
            $props = $attr['property'];
            foreach ($props as $propertyAttr) {
                $property = new Property;
                $property->setAttributes($propertyAttr);
                $this->property[] = $property;
            }
        }

        if (isset($attr['objects']) && is_array($attr['objects'])) {
            $objects = $attr['objects'];
            foreach ($objects as $objectAttr) {
                $obj = new Object;
                $obj->setAttributes($objectAttr);
                $this->objects[] = $obj;
            }
        }
    }
    
    public function getFields() {
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'name', 'label'=>'Name', 'type'=>'string');
        $fields[] = array('attribute'=>'create_date', 'label'=>'Creation Date', 'type'=>'string', 'readonly'=>true);
        $fields[] = array('attribute'=>'modify_date', 'label'=>'Modify Date', 'type'=>'string', 'readonly'=>true);
        $fields[] = array('attribute'=>'owner_user', 'label'=>'Owner User', 'type'=>'string', 'readonly'=>true);
        $fields[] = array('attribute'=>'property', 'label'=>'Property', 'type'=>'array');
        $fields[] = array('attribute'=>'objects', 'label'=>'Object', 'type'=>'array');
        return $fields;
    }
}