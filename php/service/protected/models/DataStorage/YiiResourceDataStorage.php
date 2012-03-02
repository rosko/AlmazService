<?php

include_once(dirname(__FILE__).'/../../../../core/model/Resource.php');
include_once(dirname(__FILE__).'/../../../../core/model/DataStorage/AbstractDataStorage.php');
include_once(dirname(__FILE__).'/../../../../core/transformers/CoderFactory.php');
include_once(dirname(__FILE__).'/../Resource.php');

class YiiResourceDataStorage implements AbstractDataStorage
{
    public function decodeResponse($response) {
        return CoderFactory::createCoder('json')->decode($response);
    }
    
    public function save($object) {
        $model = ARResource::model();
        $transaction = $model->getDbConnection()->beginTransaction();
        
        try
        {
            if (isset($object->id) && $object->id !== 0)
                $resource = $model->findByPk($object->id);
            
            if (!isset($resource) || is_null($resource))
                $resource = new ARResource;
            
            $object->type = 'image';
            
            $class = ResourceType::model()->find('name=:name', array('name'=>'image'));
            if (!$class) {
                throw new Exception('Invalid CLASS');
            }
            
            $resource->type_id = $class->id;
            
            if (!$resource->save()) {
                throw new Exception('Could not save RESOURCE_TYPE');
            }
            
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            return false;
        }
        
        return true;
    }
    
    public function remove($object) {
        
    }
}