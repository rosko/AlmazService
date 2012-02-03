<?php

require_once(dirname(__FILE__).'/Class.php');
require_once(dirname(__FILE__).'/Property.php');
require_once(dirname(__FILE__).'/Object.php');
require_once(dirname(__FILE__).'/Resource.php');

class DataModelFactory
{
    public static function createDataObjectWithType($type) {
        if ($type == 'class')
            $object = DataModelFactory::createDataObject('ClassName');
        else if ($type == 'meta')
            $object = DataModelFactory::createDataObject('Property');
        else if ($type == 'object')
            $object = DataModelFactory::createDataObject('Object');
        else if ($type == 'resource')
            $object = DataModelFactory::createDataObject('Resource');
        else
            $object = null;
        return $object;
    }
    
    public static function createDataObject($className) {
        if (!class_exists($className))
            throw new Exception('Could not find the Finder class for type='.$className);
        return new $className();
    }
}