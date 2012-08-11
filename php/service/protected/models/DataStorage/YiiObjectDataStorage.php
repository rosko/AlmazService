<?php

include_once(dirname(__FILE__).'/../Object.php');
include_once(dirname(__FILE__).'/../../../../core/model/Object.php');
include_once(dirname(__FILE__).'/../../../../core/model/DataStorage/AbstractDataStorage.php');

class YiiObjectDataStorage implements AbstractDataStorage
{
    private function synchronizeProperties($object, $properties) {
        $props = array();
        foreach ($properties as $property) {
            $props[$property->key_name] = $property;
        }
        
        // Removed all meta from database if this property not exists in new property list
        $keys = array_keys($props);
        foreach ($object->metas as $objectMetaData) {
            if (!isset($keys[$objectMetaData->meta->key_name]))
                ObjectMetaData::model()->deleteByPk($objectMetaData->id);
            unset($keys[$objectMetaData->meta->key_name]);
        }
        
        // Add or Update all properties
        foreach ($properties as $property) {
            $meta = MetaDataKey::model()->find('key_name = :name', array('name' => $property->key_name));
            if (is_null($meta) || !isset($meta))
                throw new Exception('Property not found');
            
            $objectProperty = ObjectMetaData::model()->find('object_id = :objid and meta_key_id = :metaid', 
                                                            array('objid' => $object->id, 'metaid' => $meta->id));
            if (is_null($objectProperty) || !isset($objectProperty)) {
                $objectProperty = new ObjectMetaData;
                $objectProperty->object_id = $object->id;
                $objectProperty->meta_key_id = $meta->id;
            }
            
            $objectProperty->meta_value = $property->value;
            
            if (!$objectProperty->save())
                throw new Exception('Could not save ObjectProperty');
        }
    }
    
    public function save($object) {
        $model = CoreObject::model();
        $transaction = $model->getDbConnection()->beginTransaction();
        
        try
        {
            if (isset($object->id))
                $storedObject = $model->findByPk($object->id);
            
            if (!isset($storedObject) || is_null($storedObject))
                $storedObject = new CoreObject;
            
            $storedObject->text_value = $object->text_value;
            $storedObject->name = $object->name;
            $storedObject->descr = $object->descr;
            
            if (!$storedObject->save())
                throw new Exception('Could not save OBJECT');
            
            $this->synchronizeProperties($storedObject, $object->property);
            
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
    
    public function remove($object) {
        $transaction = CoreObject::mode()->getDbConnection()->beginTransaction();
        
        try
        {
            if (CoreObject::mode()->deleteByPk($object->id) == false)
                throw new Exception('Could not remove object');
            
            ObjectMetaData::model()->deleteAll('object_id=:objid', array('objid'=>$object->id));
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
    
    public function decodeResponse($data) {
        $json = new CJSON();
        return $json->decode($data);
    }
}