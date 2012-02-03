<?php

include_once(dirname(__FILE__).'/../service/ResourceService.php');
include_once(dirname(__FILE__).'/../../../core/model/Finder/FinderFactory.php');
include_once(dirname(__FILE__).'/../../../core/model/DataStorage/DataStorageFactory.php');
include_once(dirname(__FILE__).'/../../../core/model/DataModelFactory.php');

//////////////////////////////////////////////////////////////////////////////////////////////////

class ManagerController extends CController
{
    public function actionIndex() {
        $service = new ResourceService('resourceservice.local');
        
        $shemaDataProvider = new CArrayDataProvider($service->getEntityTypeList());
        
        $class_name_list = array();
        $class_list = $service->getEntityList('class');
        foreach ($class_list as $class) {
            $class_name_list[] = array(
                'id'=>$class->id,
                'name'=>$class->name,
            );
        }
        
        $resourceDataProvider = new CArrayDataProvider($class_name_list);
        
        $this->render('index', array(
            'shemaDataProvider'=>$shemaDataProvider,
            'resourceDataProvider'=>$resourceDataProvider,
        ));
    }
    
    public function actionEntity() {
        $type = $_GET['type'];
        if (!isset($type))
            die('Type is invalid');
        
        $service = new ResourceService('resourceservice.local');
        $objects = $service->getEntityList($type);
        $dataProvider = new CArrayDataProvider($objects);
        
        $this->render('ShemaView', array(
            'dataProvider'=>$dataProvider,
            'type'=>$type,
        ));
    }
    
    ////////////////////////////////////////////////
    
    public function actionShowForm() {
        $type = $_GET['type'];
        $id = $_GET['id'];
        
        if (!isset($type))
            die('Error: Invalid type');
        
        if (isset($id)) {
            $finder = FinderFactory::createFinderWithType($type);
            $object = $finder->findById($id);
        } else {
            $object = DataModelFactory::createDataObjectWithType($type);
        }
        
        $this->render('ShemaEditView', array(
            'type'=>$type,
            'object'=>$object,
        ));
    }
    
    public function actionShemaSave() {
        $type = $_GET['type'];
        if ($type === null)
            die('Invalid ShemaObject TYPE');
        
        $id = $_GET['id'];
        
        if ($id === null) {
            $object = DataModelFactory::createDataObjectWithType($type);
        } else {
            $finder = FinderFactory::createFinderWithType($type);
            $object = $finder->findById($id);
        }
        
        if ($object !== null) {
            $object->setAttributes($_GET);
            
            $storage = DataStorageFactory::createDataStorageWithType($type);
            $storage->save($object);
        }
        
        $this->redirect(Yii::app()->createUrl('manager/entity', array('type'=>$type)));
    }
    
    public function actionShemaRemove() {
        if (!isset($_GET['id']) || !isset($_GET['type']))
            die('Error: Invalid ID or TYPE');
        
        $type = $_GET['type'];
        if ($type === null)
            die('Invalid ShemaObject TYPE');
        
        $id = $_GET['id'];
        if ($id === null)
            die('Invalid ShemaObject ID');
        
        $finder = FinderFactory::createFinderWithType($type);
        $object = $finder->findById($id);

        if ($object !== null) {
            $storage = DataStorageFactory::createDataStorageWithType($type);
            $storage->remove($object);
        }
    }
    
    ////////////////////////////////////////////////
    
    public function actionResource() {
        $type = $_GET['type'];
        if (!isset($type))
            die('Type is invalid');
        
        $id = $_GET['id'];
        if (!isset($id)) die('ID is invalid');
        
        $service = new ResourceService('resourceservice.local');
        $objects = $service->getResourceTypeList($type);
        $dataProvider = new CArrayDataProvider($objects);

        $this->render('ResourceListView', array(
            'dataProvider'=>$dataProvider,
            'type'=>$type,
            'id'=>$id,
        ));
    }
    
    public function actionResourceCreate() {
        $type = $_GET['type'];
        if (!isset($type)) die('TYPE is invalid');
        
        $id = $_GET['id'];
        if (!isset($id)) die('ID is invalid');
        
        $service = new ResourceService('resourceservice.local');
        $resource_class = $service->getEntityById('class', $id);
        
        $this->render('ResourceView', array(
            'class'=>$resource_class,
            'type'=>$type,
        ));
    }
    
    public function actionResourceSave() {
        $class_id = $_GET['class_id'];
        $type = $_GET['type'];
        
        $service = new ResourceService('resourceservice.local');
        $resource_class = $service->getEntityById('class', $class_id);
        
        $property = $resource_class['property'];
        
        $props = array();
        
        foreach ($property as $class_property) {
            $key = $class_property['key_name'];
            $props[$key] = $_POST[$key];
        }
        
        $resource = array(
            'type_id'=>$class_id,
            'owner_id'=>0,
            'create_date'=>123123,
            'update_date'=>4353423,
            'property'=>$props,
        );
        
        $service->saveResource($type, $resource);
    }
}
