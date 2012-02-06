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
    
    private $create_date;
    
    private $modify_date;
    
    private $owner_user;
    
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
        $attr['descr'] = $this->descr;
        $attr['create_date'] = $this->creation_date;
        $attr['modify_date'] = $this->modify_date;
        $attr['owner_user'] = $this->owner_user;
        return $attr;
    }
    
    public function setAttributes($attr) {
        parent::setAttributes($attr);
//        $this->descr = $attr['descr'];
    }
    
    public function getFields() {
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'descr', 'label'=>'Description', 'type'=>'string');
        $fields[] = array('attribute'=>'create_date', 'label'=>'Creation Date', 'type'=>'string');
        $fields[] = array('attribute'=>'modify_date', 'label'=>'Modify Date', 'type'=>'string');
        $fields[] = array('attribute'=>'owner_user', 'label'=>'Owner User', 'type'=>'string');
        return $fields;
    }
}