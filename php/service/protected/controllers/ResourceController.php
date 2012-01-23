<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');

class ResourceController {

    public function actionIndex() {
    }
    
    // 
    // URL Format: api/<type>/<idid>.<format>
    //
    // type - Resource type
    // id - Resource id
    // format = Response format
    //
    public function actionView() {
        if (!Parameters::hasParam('type'))
            die('ServiceController: Invalid resource TYPE (parameter name: \'type\')');
        
        $resource_type = Parameters::get('type');
        
        if (!Parameters::hasParam('id'))
            die('ServiceController: Invalid resource IDENTIFICATOR (parameter name: \'id\')');
        
        $criteria = new CDbCriteria;
        $criteria->alias = 'r';
        $criteria->addCondition('name=:resource_type');
        $criteria->params = array(':resource_type' => $resource_type);
        $criteria->addCondition('r.id=:resource_id');
        $criteria->params[':resource_id'] = Parameters::getInt('id');
        
        $result = Resource::model()->with('type')->findAll($criteria);
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        if ($coder != nil) {
            $response = $coder->encode($result);
            echo $response;
        }
        
        return $result;
    }
    
    // 
    // URL Format: api/<type>.<format>
    //
    // type - Resource type
    // format = Response format
    //
    public function actionList() {
        $resource_type = Parameters::get('type');
        
        $criteria = new CDbCriteria;
        $criteria->alias = 'r';
        $criteria->addCondition('name=:resource_type');
        $criteria->params = array(':resource_type' => $resource_type);
        
        if (Parameters::hasParam('from'))
            $criteria->offset = Parameters::getInt('from');
        
        // Result records number
        if (Parameters::hasParam('count'))
            $criteria->limit = Parameters::getInt('count');
        
        $result = Resource::model()->with('type')->findAll($criteria);
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        if ($coder != nil) {
            $response = $coder->encode($result);
            echo $response;
        }
        
        return $result;
    }
    
    public function actionUpdate() {
    }
    
    public function actionCreate() {
        if (!Parameters::hasParam('type'))
            die('ResourceController: Resource type not valid (parameter name: \'type\')');
        
        if (!Parameters::hasParam('data', 'post'))
            die('ResourceController: Have no object for put (parameter name: \'data\', method: \'POST\')');
        
        $resource_type = Parameters::get('type');
        $resource_object = Parameters::get('data', 'post');
        $response = 'FAIL';
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        
        $resource = new Resource();
        
        $coder = ObjectCodingFactory::factory()->createObject($format);
        
//        $resource = $coder->decode($resource_object);
        $resource->decodeWithCoder($coder);
        
        if ($resource->save())
            $response = 'OK';
        
        return $response;
    }
    
    public function actionDelete() {
        if (!Parameters::hasParam('id'))
            die('ServiceController: Invalid resource IDENTIFICATOR (parameter name: \'id\')');
        
        $id = Parameters::get('id');
        $response = 'FAIL';
        
        if (Resource::model()->deleteByPk($id) == 1)
            $response = 'OK';
        
        return $response;
    }
    
    public function actionSearch() {
        
    }
}