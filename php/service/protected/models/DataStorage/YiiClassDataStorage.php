<?php

include_once(dirname(__FILE__).'/../../../../core/model/Class.php');
include_once(dirname(__FILE__).'/../../../../core/model/DataStorage/AbstractDataStorage.php');

class YiiClassDataStorage implements AbstractDataStorage
{
    private function synchronizeProperties($resourceType, $properties) {
        $propNames = array();
        foreach ($properties as $prop) {
            $propNames[$prop->key_name] = $prop;
        }
        
        $keys = array_keys($propNames);
        foreach ($resourceType->metas as $resourceTypeMeta) {
            if (!isset($keys[$resourceTypeMeta->meta->key_name]))
                ResourceTypeMetas::model()->deleteByPk($resourceTypeMeta->id);
            unset($keys[$resourceTypeMeta->meta->key_name]);
        }
        
        foreach ($propNames as $propertyName => $property) {
            $meta = MetaDataKey::model()->find('key_name = :name', array('name' => $propertyName));
            if (is_null($meta)) {
                $meta = new MetaDataKey;
                $meta->key_name = $property->key_name;
                
                if (!$meta->save())
                    throw new Exception('Could not save PROPERTY');
            }
            
            $relation = new ResourceTypeMetas;
            $relation->resource_type_id = $resourceType->id;
            $relation->meta_key_id = $meta->id;
            
            if (!$relation->save())
                throw new Exception('Could not save RELATION');
        }
    }
    
    public function save($object) {
        $model = ResourceType::model();
        $transaction = $model->getDbConnection()->beginTransaction();
        
        try
        {
            if (isset($object->id) && $object->id !== 0)
                $resourceType = $model->findByPk($object->id);
            
            if (!isset($resourceType) || is_null($resourceType))
                $resourceType = new ResourceType;
            
            $resourceType->name = $object->name;
            $resourceType->descr = $object->descr;

            if (!$resourceType->save()) {
                throw new Exception('Could not save RESOURCE_TYPE');
            }
            
            $this->synchronizeProperties($resourceType, $object->property);
            
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
    
    public function remove($object) {
        return ResourceType::model()->deleteByPk($object->id);
    }
    
    public function decodeResponse($data) {
        $json = new CJSON();
        return $json->decode($data);
    }
}