<?php

include_once(dirname(__FILE__).'/../../../../core/model/Property.php');
include_once(dirname(__FILE__).'/../../../../core/model/DataStorage/AbstractDataStorage.php');

class YiiPropertyDataStorage implements AbstractDataStorage
{
    public function save($object) {
        $model = MetaDataKey::model();
        $transaction = $model->getDbConnection()->beginTransaction();
        
        try
        {
            if (isset($object->id))
                $property = MetaDataKey::model()->findByPk($object->id);

            if (!isset($property) || is_null($property))
                $property = new MetaDataKey;

            $property->key_name = $object->key_name;
            $property->descr = $object->descr;
            
            if (!$property->save())
                throw new Exception('Could not save PROPERTY');
            
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
    
    public function remove($object) {
        return MetaDataKey::model()->deleteByPk($object->id);
    }
    
    public function decodeResponse($data) {
        $json = new CJSON();
        return $json->decode($data);
    }
}