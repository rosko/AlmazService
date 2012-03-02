<?php

include_once(dirname(__FILE__).'/../service/ResourceService.php');
include_once(dirname(__FILE__).'/../../../core/model/Finder/FinderFactory.php');
include_once(dirname(__FILE__).'/../../../core/model/DataStorage/DataStorageFactory.php');
include_once(dirname(__FILE__).'/../../../core/model/DataModelFactory.php');

//////////////////////////////////////////////////////////////////////////////////////////////////

class ManagerController extends CController
{
    public $layout = 'manager';
    public $selectedTab = 'Shema';
    
    public function getActiveTab() {
        return $this->selectedTab;
    }
    
    private function setActiveTab($tabLabel) {
        $this->selectedTab = $tabLabel;
    }
    
    
    public function actionIndex() {
        $this->redirect(Yii::app()->createUrl('manager/shema'));
    }
    
    public function actionShema($shema = null) {
        $service = new ResourceService('resourceservice.local');
        $shemaDataProvider = new CArrayDataProvider($service->getEntityTypeList());
        
        if (is_null($shema))
            $shema = $shemaDataProvider->rawData[0];

        $dataProvider = new CArrayDataProvider($service->getEntityList($shema),
                array('pagination'=>array('pageSize'=>20)));
        
        $this->setActiveTab('Shema');
        
        $this->render('index', array(
            'shemaDataProvider'=>$shemaDataProvider,
            'shema'=>$shema,
            'dataProvider'=>$dataProvider
        ));
    }
    
    public function actionResources($resource = null) {
        $service = new ResourceService('resourceservice.local');
        
        // Fetch all resource classes
        $class_name_list = array();
        $class_list = $service->getEntityList('class');
        foreach ($class_list as $class) {
            $class_name_list[] = array(
                'id'=>$class->id,
                'name'=>$class->name,
            );
        }
        
        $resourceDataProvider = new CArrayDataProvider($class_name_list);
        
        // Fetch resources by resource class name
        if (is_null($resource))
            $resource = $resourceDataProvider->rawData[0]['name'];
        
        try {
            $finder = FinderFactory::createFinderWithType('resource');
            $finder->setType($resource);
            //$finder->setDevKey('__private_dev_key__');
            $resources = $finder->findAll();

            $dataProvider = new CArrayDataProvider($resources);

        } catch (Exception $e) {
            die($e->getMessage());
        }
        
        // Render resource view
        $this->setActiveTab('Resources');
        $this->render('resources', array(
            'resourceDataProvider'=>$resourceDataProvider,
            'dataProvider'=>$dataProvider,
            'resource'=>$resource
        ));
    }
    
    public function actionUser() {
        die('UserPage NotImplemented');
    }
    
    public function actionClient() {
        die('ClientPage NotImplemented');
    }
    
    ////////////////////////////////////////////////////////////////////////
    
    public function actionAddResource() {
        die('AddResource');
    }
    
    /**
     * Show view for selected shema type
     * @param type $shema
     * @param type $id 
     */
    public function actionViewShemaObject($shema = null, $id = null) { 
        if (!is_null($id)) {
            $finder = FinderFactory::createFinderWithType($shema);
            $object = $finder->findById($id);
        }
        
        if (!isset($object) || is_null($object))
            $object = DataModelFactory::createDataObjectWithType($shema);
        
        $params = array('object'=>$object, 'shema'=>$shema);
        
        if ($shema === 'object') {
            $finder = FinderFactory::createFinderWithType('meta');
            $params['property'] = $finder->findAll();
        }
        
        $this->render($shema.'view', $params);
    }
    
    /**
     * Remove shema object by type and id
     * @param type $shema
     * @param type $id 
     */
    public function actionRemoveShemaObject($shema, $id) {
        $finder = FinderFactory::createFinderWithType($shema);
        $object = $finder->findById($id);

        if ($object !== null) {
            $storage = DataStorageFactory::createDataStorageWithType($shema);
            $storage->remove($object);
        }
        
        $this->redirect(Yii::app()->createUrl('manager/shema', array('shema'=>$shema)));
    }
    
    /**
     * Save shema object. All params must be passed vie POST method.
     */
    public function actionSaveShemaObject() {
        if (!isset($_POST['shema']))
            die('Invalid shema'); //TODO
        
        $attr = $_POST;
        $type = $attr['shema'];
        
        $object = DataModelFactory::createDataObjectWithType($type);
        $object->setAttributes($attr);
        
        $storage = DataStorageFactory::createDataStorageWithType($type);
        $storage->save($object);
        
        $this->redirect(Yii::app()->createUrl('manager/shema', array('shema'=>$type)));
    }
    
    //////////////////////////////////////////////////////////////////////////////
    
    public function actionEntity($type) {
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
    
    public function actionShowForm($type, $id) {
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
    
    public function actionShemaSave($type, $id) {
        $object = DataModelFactory::createDataObjectWithType($type);
        
        if ($object !== null) {
            $attrs = $_GET;
            if (isset($attrs['property']) && is_string($attrs['property'])) {
                $props_keys = explode(';', $attrs['property']);
                foreach ($props_keys as $keys) {
                    if (isset($keys) && $keys !== '') {
                        $one_prop['key_name'] = $keys;
                        $props[] = $one_prop;
                    }
                }
            }
            
            $attrs['property'] = $props;
            
            $object->setAttributes($attrs);
            
            $storage = DataStorageFactory::createDataStorageWithType($type);
            $storage->save($object);
        }
        
        $this->redirect(Yii::app()->createUrl('manager/entity', array('type'=>$type)));
    }
    
    public function actionShemaRemove($type, $id) {
        if (!isset($id) || !isset($type))
            die('Error: Invalid ID or TYPE');
        
        if ($type === null)
            die('Invalid ShemaObject TYPE');
        
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
    
    public function actionResource($type, $id) {
        try {
            $finder = FinderFactory::createFinderWithType('resource');
            $finder->setType($type);
            $finder->setDevKey('__private_dev_key__');
            $resources = $finder->findAll();
            
            $dataProvider = new CArrayDataProvider($resources);
            
            $this->render('ResourceListView', array(
                'dataProvider'=>$dataProvider,
                'type'=>$type,
                'id'=>$id,
            ));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function actionResourceShowForm($type, $id) {
        try {
            $finder = FinderFactory::createFinderWithType('class');
            $class = $finder->findById($id);
            
            $this->render('ResourceView', array(
                'type'=>$type,
                'object'=>$class,
            ));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function actionResourceSave($type, $id) {
        $property = array();
        
        $prefix = 'property_';
        $prefixLen = strlen($prefix);
        foreach ($_GET as $name => $value) {
            if (strstr($name, $prefix) == $name) {
                $propName = substr($name, $prefixLen);
                $property[] = array('key_name'=>$propName, 'value'=>$value);
            }
        }
        
        $attr = $_GET;
        $attr['property'] = $property;
        $attr['id'] =  0;
        
        $resource = new Resource;
        $resource->setAttributes($attr);
        
        $storage = DataStorageFactory::createDataStorageWithType('resource');
        $storage->setType($type);
        
        $storage->save($resource);
        
        $this->redirect(Yii::app()->createUrl('manager/resource', array('type'=>$type, 'id'=>$id,)));
    }
    
    public function actionResourceRemove() {
        
    }
}
