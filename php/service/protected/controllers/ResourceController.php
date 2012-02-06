<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');
include_once(dirname(__FILE__).'/APIResponseCode.php');

class ResourceController
{
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
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $resource_type = Parameters::get('type');
        
        $criteria = new CDbCriteria;
        $criteria->alias = 'r';
        $criteria->addCondition('name=:resource_type');
        $criteria->params = array(':resource_type' => $resource_type);
        $criteria->addCondition('r.id=:resource_id');
        $criteria->params[':resource_id'] = Parameters::getInt('id');
        
        $result = Resource::model()->with('type')->findAll($criteria);
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        if ($coder === nil)
            throw new APIException('Invalid Coder for format', APIResponseCode::API_INVALID_CODER);
            
        $response = $coder->encode($result);
        echo $response;
    }
    
    // 
    // URL Format: api/<type>.<format>
    //
    // type - Resource type
    // format = Response format
    //
    public function actionList() {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
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
        if ($coder === nil)
            throw new APIException('Invalid Coder for format', APIResponseCode::API_INVALID_CODER);
            
        $response = $coder->encode($result);
        echo $response;
    }
    
    public function actionUpdate() {
        throw new APIException('Method not implemented', APIResponseCode::API_RESOURCE_UPDATE_ERROR);
    }
    
    public function actionCreate() {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        if (!Parameters::hasParam('data', 'post'))
            throw new APIException('Have no object for put (parameter name: \'data\', method: \'POST\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $resource_type = Parameters::get('type');
        $resource_object = Parameters::get('data', 'post');
        
        $resource = new Resource();
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        $resource->decodeWithCoder($coder);
        
        if (!$resource->save())
            throw new APIException('Can not save resource object', APIResponseCode::API_RESOURCE_CREATE_ERROR);
    }
    
    public function actionDelete() {
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $id = Parameters::get('id');
        
        if (Resource::model()->deleteByPk($id) !== 1)
            throw new APIException('Could not delete resource object', APIResponseCode::API_RESOURCE_DELETE_ERROR);
    }
    
    public function actionSearch() {
        
    }
}