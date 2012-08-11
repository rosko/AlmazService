<?php

include_once(dirname(__FILE__).'/../../../core/model/Resource.php');
include_once(dirname(__FILE__).'/../../../core/model/DataModelFactory.php');
include_once(dirname(__FILE__).'/../models/DataStorage/YiiResourceDataStorage.php');
include_once(dirname(__FILE__).'/../models/Finder/YiiResourceFinder.php');
include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');
include_once(dirname(__FILE__).'/APIResponseCode.php');

include_once(dirname(__FILE__).'/../models/DataStorage/YiiResourceDataStorage.php');

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
        
        $finder = new YiiResourceFinder($resource_type);
        $object = $finder->findById(Parameters::get('id'));
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        if ($coder === nil)
            throw new APIException('Invalid Coder for format', APIResponseCode::API_INVALID_CODER);
            
        $response = $coder->encode($object->getAttributes());
        die($response);
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
        
//        if (!Parameters::hasParam('devkey'))
//            throw new APIException('Invalid application DEVELOPER KEY (parameter name: \'devkey\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $resource_type = Parameters::get('type');
        $devkey = Parameters::get('devkey');
        
        $finder = new YiiResourceFinder($resource_type);
//        $finder->setDevKey($devkey);
        $result = $finder->findAll();
        
        $dataSet = array();
        foreach ($result as $object) {
            $dataSet[] = $object->getAttributes();
        }
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        if ($coder === nil)
            throw new APIException('Invalid Coder for format', APIResponseCode::API_INVALID_CODER);
            
        $response = $coder->encode($dataSet);
        die($response);
        
        

        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        if ($coder === nil)
            throw new APIException('Invalid Coder for format', APIResponseCode::API_INVALID_CODER);
            
        $response = $coder->encode($result);
        echo $response;
    }
    
    public function actionUpdate() {
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        try
        {
            $obj = DataModelFactory::createDataObjectWithType('resource');
            $data = Parameters::getRaw('data', 'post');
            
            $storage = new YiiResourceDataStorage;
            $attr = $storage->decodeResponse($data);
            $obj->setAttributes($attr);
            
            $storage->save($obj);
        }
        catch (Exception $e)
        {
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_CREATE_ERROR);
        }
    }
    
    public function actionCreate() {
        try
        {
            $obj = DataModelFactory::createDataObjectWithType('resource');
            $data = Parameters::getRaw('data', 'post');
            
            $storage = new YiiResourceDataStorage;
            $attr = $storage->decodeResponse($data);
            $obj->setAttributes($attr);
            
            $storage->save($obj);
        }
        catch (Exception $e)
        {
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_CREATE_ERROR);
        }
    }
    
    public function actionDelete() {
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        try
        {
            $resource = DataModelFactory::createDataObjectWithType('resource');
            $resource->id = Parameters::get('id');
            
            $storage = new YiiResourceDataStorage;
            $storage->remove($resource);
        }
        catch (Exception $e)
        {
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_CREATE_ERROR);
        }
    }
    
    public function actionSearch() {
        
    }
}