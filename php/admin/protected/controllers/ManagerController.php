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
            if ($resource == $class->name)
                $resourceClass = $class;
        }
        
        $resourceDataProvider = new CArrayDataProvider($class_name_list);
        
        // Fetch resources by resource class name
        if (!isset($resourceClass) || is_null($resourceClass))
            $resourceClass = $class_list[0];
        
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
            'resource'=>$resourceClass
        ));
    }
    
    public function actionUser() {
        die('UserPage NotImplemented');
    }
    
    public function actionClient() {
        die('ClientPage NotImplemented');
    }
    
    ////////////////////////////////////////////////////////////////////////
    
    public function actionAddResource($type = null, $id = null) {
        $finder = FinderFactory::createFinderWithType('class');
        $class = $finder->findById($id);
        
        $resource = new Resource;

        $finder = FinderFactory::createFinderWithType('object');
        $objects = $finder->findAll();

        $this->setActiveTab('Resources');
        $this->render('resourceadd', array(
            'type' => $type,
            'class' => $class,
            'resource' => $resource,
            'objects' => $objects,
        ));
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
            $params['propertyList'] = $finder->findAll();
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
    
    public function actionSaveResourceObject() {
        $attr = $_POST;
        $type = $attr['type'];

        $object = DataModelFactory::createDataObjectWithType('resource');
        $object->setAttributes($attr);

        $storage = DataStorageFactory::createDataStorageWithType('resource');
        $storage->setType($type);
        $storage->save($object);
        
        $this->redirect(Yii::app()->createUrl('manager/resources', array('resource'=>$type)));
    }
    
    
    public function actionRemoveResourceObject($type = null, $id = null) {
        $finder = FinderFactory::createFinderWithType('resource');
        $finder->setType($type);
        
        $object = $finder->findById($id);
        
        if ($object !== null) {
            $storage = DataStorageFactory::createDataStorageWithType('resource');
            $storage->setType($type);
            $storage->remove($object);
        }
        
        $this->redirect(Yii::app()->createUrl('manager/resources', array('resource'=>$type)));
    }
    
    public function actionViewResourceObject($id, $type, $type_id) {

        $finder = FinderFactory::createFinderWithType('class');
        $class = $finder->findById(intval($type_id));

        $finder = FinderFactory::createFinderWithType('resource');
        $finder->setType($type);
        $resource = $finder->findById(intval($id));

        $finder = FinderFactory::createFinderWithType('object');
        $objects = $finder->findAll();

        $this->setActiveTab('Resources');
        $this->render('resourceview', array(
                   'type' => $type,
                   'class' => $class,
                   'resource' => $resource,
                   'objects' => $objects,
         ));

    }
}
