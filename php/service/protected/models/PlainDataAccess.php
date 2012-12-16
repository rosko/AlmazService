<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sshkrabak
 * Date: 9/10/12
 * Time: 11:44 PM
 * To change this template use File | Settings | File Templates.
 */

include_once(__SERVICE_SRC_DIR__.'/utils/Factory.php');
include_once(__SERVICE_SRC_DIR__.'/models/DataStorage/YiiClassDataStorage.php');
include_once(__SERVICE_SRC_DIR__.'/models/DataStorage/YiiObjectDataStorage.php');
include_once(__SERVICE_SRC_DIR__.'/models/DataStorage/YiiPropertyDataStorage.php');
include_once(__SERVICE_SRC_DIR__.'/models/DataStorage/YiiResourceDataStorage.php');
include_once(__SERVICE_SRC_DIR__.'/models/DataStorage/YiiUserDataStorage.php');
//include_once(__SERVICE_SRC_DIR__.'/models/DataStorage/YiiClientAppDataStorage.php');
include_once(__SERVICE_SRC_DIR__.'/models/Finder/YiiDataFinder.php');

class DataStorageFactory extends Factory
{
    public function __construct()
    {
        parent::registerType('class', 'YiiClassDataStorage');
        parent::registerType('meta', 'YiiPropertyDataStorage');
        parent::registerType('object', 'YiiObjectDataStorage');
        parent::registerType('resource', 'YiiResourceDataStorage');
        parent::registerType('users', 'YiiUserDataStorage');
        //parent::registerType('apps', 'YiiClientAppDataStorage');
    }
}

class FinderFactory extends Factory
{
    public function __construct()
    {
        parent::registerType('class', 'ResourceType');
        parent::registerType('meta', 'MetaDataKey');
        parent::registerType('object', 'CoreObject');
        parent::registerType('users', 'ARUser');
        parent::registerType('apps', 'ARClientApp');
    }

    public function createObject($type)
    {
        $className = parent::getClassName($type);
        if (!isset($className))
            return NULL;
        return new YiiDataFinder($className::model());
    }
}


class PlainDataAccess
{
    public function get($coreModelName, $id)
    {
        $finder = FinderFactory::factory()->createObject($coreModelName);
        if ($finder == NULL)
            return false;

        return $finder->findById($id);
    }

    public function getAll($coreModelName)
    {
        $finder = FinderFactory::factory()->createObject($coreModelName);
        if ($finder == NULL)
            return false;
        
        return $finder->findAll();
    }

    public function save($coreModelName, $attributes)
    {

    }

    public function delete($coreModelName, $id)
    {
        $storage = DataStorageFactory::factory()->createObject($coreModelName);

        return true; //return $storage->removeById($id);
    }
}
