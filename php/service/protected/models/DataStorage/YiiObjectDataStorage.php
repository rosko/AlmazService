<?php

include_once(dirname(__FILE__).'/../../../../core/model/Object.php');
include_once(dirname(__FILE__).'/../Object.php');
include_once(dirname(__FILE__).'/../../../../core/model/DataStorage/AbstractDataStorage.php');

class YiiObjectDataStorage implements AbstractDataStorage
{
    public function save($object) {
        $model = CoreObject::model();
        $transaction = $model->getDbConnection()->beginTransaction();
        
        try
        {
            if (isset($object->id))
                $storedObject = $model->findByPk ($object->id);
            
            if (!isset($storedObject) || is_null($storedObject))
                $storedObject = new CoreObject;
            
            $storedObject->text_value = $object->text_value;
            $storedObject->name = $object->name;
            $storedObject->descr = $object->descr;
            // Need to add all properties
            
            if (!$storedObject->save())
                throw new Exception('Could not save OBJECT');
            
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
    
    public function remove($object) {
        
    }
    
    public function decodeResponse($data) {
        $json = new CJSON();
        return $json->decode($data);
    }
}