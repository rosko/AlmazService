<?php

include_once(dirname(__FILE__).'/../service/ResourceService.php');

class Entity {
}

class ClassEntity extends Entity {
    public $name = null;
    public $id = null;
    public $descr = null;
    
    public function initWithArray($array) {
        if (!is_null($array)) {
            $this->name = $array['name'];
            $this->id = $array['id'];
            $this->descr = $array['descr'];
        }
    }
}

class MetaEntity extends Entity {
    public $id = null;
    public $key_name = null;
    public $descr = null;
    
    public function initWithArray($array) {
        if (!is_null($array)) {
            $this->key_name = $array['key_name'];
            $this->id = $array['id'];
            $this->descr = $array['descr'];
        }
    }
}

class ObjectEntity extends Entity {
    public $name = null;
    public $id = null;
    public $descr = null;
    
    public function initWithArray($array) {
        if (!is_null($array)) {
            $this->name = $array['name'];
            $this->id = $array['id'];
            $this->descr = $array['descr'];
        }
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////

class EntityFactory {
    public static function createEntity($type) {
        switch ($type) {
            case 'class': return new ClassEntity();
            case 'object': return new ObjectEntity();
            case 'meta': return new MetaEntity();
        }
        return null;
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////

class ManagerController extends CController {
    public $str;
    public $dataProvider;
    public $dataColumn = null;
    
    public function actionIndex() {
        $service = new ResourceService('resourceservice.local');
        
        $shemaDataProvider = new CArrayDataProvider($service->getEntityTypeList());
        
        $class_name_list = array();
        $class_list = $service->getEntityList('class');
        $class_name_list = $class_list;
        // foreach ($class_list as $class) {
        //     $class_name_list[] = $class['name'];
        // }
        
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
    ////////////////////////////////////////////////
    
    public function actionCreate() {
        $type = $_GET['type'];
        if (!isset($type))
            die('Type is invalid');
        
        $this->render('newentity');
    }
    
    public function actionDelete() {
        $type = $_GET['type'];
        $id = $_GET['id'];
        
        if (is_null($type) || is_null($id)) {
            die("Invalid type or id");
        }
        
        $service = new ResourceService('resourceservice.local');
        $service->removeEntity($type, $id);
    }
    
    public function actionSave() {
        $type = $_GET['type'];
        if (!isset($type)) {
            die('Type is invalid');
        }
        
        $id = $_GET['id'];
        if (!isset($id)) {
            $id = 0;
        }
        
        $service = new ResourceService('resourceservice.local');
        
        $object = EntityFactory::createEntity($type);
        $object->initWithArray($_GET);
        
        $response = $service->saveEntity($type, $object, $id);
        
        $this->redirect(Yii::app()->createUrl('manager/entity', array('type'=>$type)));
    }
    
    public function actionUpdate() {
        $type = $_GET['type'];
        if (!isset($type))
            die('Type is invalid');
        
        $id = $_GET['id'];
        
        $service = new ResourceService('resourceservice.local');
        $object = $service->getEntityById($type, $id);
        
        $this->render('newentity', array(
            'type'=>$type,
            'data'=>$object,
        ));
    }
}
