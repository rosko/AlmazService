<?php

include_once(dirname(__FILE__).'/../../../../core/model/Resource.php');
include_once(dirname(__FILE__).'/../../../../core/model/DataStorage/AbstractDataStorage.php');
include_once(dirname(__FILE__).'/../../../../core/transformers/CoderFactory.php');
include_once(dirname(__FILE__).'/../Resource.php');

class YiiResourceDataStorage implements AbstractDataStorage
{
    private function synchronizeProperties($resource, $properties) {
        $props = array();
        
        foreach ($properties as $property) {
            $props[$property->key_name] = $property;
        }
        
        // Removed all meta from database if this property not exists in new property list
        $keys = array_keys($props);
        foreach ($resource->metas as $resourceMetaData) {
            if (!isset($keys[$resourceMetaData->meta->key_name]))
                ResourceMetaData::model()->deleteByPk($resourceMetaData->id);
            unset($keys[$resourceMetaData->meta->key_name]);
        }

        // Add or Update all properties
        foreach ($properties as $property) {
            $meta = MetaDataKey::model()->find('key_name = :name', array('name' => $property->key_name));
            if (is_null($meta) || !isset($meta))
                throw new Exception('Property not found');
            
            $resourceProperty = ResourceMetaData::model()->find('resource_id = :resid and meta_key_id = :metaid', 
                                                            array('resid' => $resource->id, 'metaid' => $meta->id));
            if (is_null($resourceProperty) || !isset($resourceProperty)) {
                $resourceProperty = new ResourceMetaData;
                $resourceProperty->resource_id = $resource->id;
                $resourceProperty->meta_key_id = $meta->id;
            }
            
            $resourceProperty->meta_value = $property->value;
            
            if (!$resourceProperty->save())
                throw new Exception('Could not save ObjectProperty');
        }
    }

    private function synchronizeOjbects($resource, $objects) {

        ResourceObject::model()->deleteAll('resource_id = :id', array('id' => $resource->id));

        $order = 0;
        foreach ($objects as $object) {

            $resourceObject = new ResourceObject;
            $resourceObject->resource_id = $resource->id;
            $resourceObject->object_id = $object->id;
            $resourceObject->order = $order++;
            if (!$resourceObject->save())
                throw new Exception('Could not save ResourceObject');

        }

    }
    
    public function save($object) {
        $model = ARResource::model();
        $transaction = $model->getDbConnection()->beginTransaction();
        
        try
        {
            if (isset($object->id) && $object->id !== 0)
                $resource = $model->findByPk($object->id);
            
            if (!isset($resource) || is_null($resource)) {
                $resource = $model->find('name = :name', array('name'=>$object->name));
                if (isset($resource) && !is_null($resource))
                    throw new Exception('Resource with name already exists');
                
                $resource = new ARResource;
                $resource->create_date = time();
            }
            
            $class = ResourceType::model()->find('name=:name', array('name'=>$object->type));
            if (!$class) {
                throw new Exception('Invalid CLASS');
            }
            
            $resource->type_id = $class->id;
            $resource->name = $object->name;
            $resource->update_date = time();

            if (!$resource->save()) {
                throw new Exception('Could not save RESOURCE_TYPE');
            }

            $this->synchronizeProperties($resource, $object->property);
            $this->synchronizeOjbects($resource, $object->objects);
            
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
        
        return true;
    }
    
    public function remove($object) {
        $transaction = ARResource::model()->getDbConnection()->beginTransaction();
        
        try
        {
            if (ARResource::model()->deleteByPk($object->id) == false)
                throw new Exception('Could not remove object');
            
            ResourceMetaData::model()->deleteAll('resource_id=:resid', array('resid'=>$object->id));
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
    
    public function decodeResponse($response) {
        return CoderFactory::createCoder('json')->decode($response);
    }
}