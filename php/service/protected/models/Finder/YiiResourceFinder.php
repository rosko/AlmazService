<?php

include_once(dirname(__FILE__).'/YiiDataFinder.php');
include_once(dirname(__FILE__).'/../../../../core/model/Resource.php');
include_once(dirname(__FILE__).'/../../../../core/model/Property.php');

class YiiResourceFinder extends YiiDataFinder
{
    private $type = null;
    private $devkey = null;
    
    public function __construct($type, $devkey = null) {
        parent::__construct(ARResource::model());
        $this->type = $type;
        $this->devkey = $devkey;
    }
    
    public function prepareObjectAttributes($record) {
        $property = array();
        foreach ($record->meta as $meta) {
            //
            // NEED TO REFACTORED
            //
            $prop_attr['key_name'] = $meta->metadata->key_name;
            $prop_attr['value'] = $meta->meta_value;
            $prop_attr['descr'] = $meta->metadata->descr;
            $prop_attr['id'] = $meta->id;
            //
            // ====
            
            $prop = new Property;
            $prop->setAttributes($prop_attr);
            $property[] = $prop->getAttributes();
        }
        
        $attr = $record->getAttributes();
        $attr['type'] = $record->type->name;
        $attr['property'] = $property;
        
        return $attr;
    }
    
    public function createDataObject($attr) {
        $resource = new Resource;
        $resource->setAttributes($attr);
        return $resource;
    }
    
    /*
     * SELECT * FROM Resource AS r
     * INNER JOIN ResourceType as type ON r.type_id = type.id AND type.name = :resource_type
     * INNER JOIN ClientApplication as client ON client.dev_key = :dev_key
     * INNER JOIN Application as app ON app.resource_id = r.id AND app.client_application_id = client.id
     */
    public function findAllInDatabase() {
        $criteria = new CDbCriteria;
        $criteria->alias = 'r';
        $criteria->addCondition('name=:resource_type');
        $criteria->params = array(':resource_type' => $this->type);
        
        $conditions = array($criteria);
        
        if (is_null($this->devkey) || !isset($this->devkey)) {
            $criteria2 = $criteria;
        } else {
            $criteria2 = new CDbCriteria;
            $criteria2->condition = '
                SELECT * FROM Resource AS r
                INNER JOIN ResourceType as type ON r.type_id = type.id AND type.name = :resource_type
                INNER JOIN ClientApplication as client ON client.dev_key = :dev_key
                INNER JOIN Application as app ON app.resource_id = r.id AND app.client_application_id = client.id
            ';
            $criteria2->params = array(
                'resource_type' => $this->type,
                'dev_key' => $this->devkey,
            );
        }
        
        return ARResource::model()->with('type')->findAll($criteria2);
    }
}
