<?php

require_once(dirname(__FILE__).'/RemoteClassStorage.php');
require_once(dirname(__FILE__).'/RemotePropertyStorage.php');
require_once(dirname(__FILE__).'/RemoteObjectStorage.php');
require_once(dirname(__FILE__).'/RemoteResourceStorage.php');

class DataStorageFactory
{
    public static function createDataStorageWithType($type) {
        if ($type == 'class')
            $object = DataModelFactory::createDataObject('RemoteClassStorage');
        else if ($type == 'meta')
            $object = DataModelFactory::createDataObject('RemotePropertyStorage');
        else if ($type == 'object')
            $object = DataModelFactory::createDataObject('RemoteObjectStorage');
        else if ($type == 'resource')
            $object = DataModelFactory::createDataObject('RemoteResourceStorage');
        else
            $object = null;
        return $object;
    }
    
    public static function createDataStorage($type) {
        if (!class_exists($type))
            throw new Exception('Could not find the DataStorage class for type='.$type);
        return new $type();
    }
}