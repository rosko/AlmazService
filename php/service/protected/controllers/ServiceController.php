<?php

include_once(dirname(__FILE__).'/APIResponseCode.php');
include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');
include_once(dirname(__FILE__).'/../models/DataStorage/YiiClassDataStorage.php');
include_once(dirname(__FILE__).'/../models/DataStorage/YiiPropertyDataStorage.php');
include_once(dirname(__FILE__).'/../models/DataStorage/YiiObjectDataStorage.php');
include_once(dirname(__FILE__).'/../models/DataStorage/YiiResourceDataStorage.php');
include_once(dirname(__FILE__).'/../models/Finder/YiiDataFinder.php');
include_once(dirname(__FILE__).'/../../../core/model/Class.php');
include_once(dirname(__FILE__).'/../../../core/model/Property.php');
include_once(dirname(__FILE__).'/../../../core/model/Object.php');
include_once(dirname(__FILE__).'/../../../core/model/DataModelFactory.php');

class DataStorageFactory
{
    public static function createStorage($type) {
        if ($type === 'class')
            return new YiiClassDataStorage ();
        else if ($type === 'meta')
            return new YiiPropertyDataStorage();
        else if ($type === 'object')
            return new YiiObjectDataStorage();
        else if ($type === 'resource')
            return new YiiResourceDataStorage();
        return null;
    }
}

class FinderFactory
{
    public static function createFinder($type) {
        return new YiiDataFinder($type);
    }
}

class ServiceController
{
    private $model_class_map = array();
    
    public function __construct()
    {
        $this->model_class_map = array(
            'class'=>'ResourceType',
            'object'=>'CoreObject',
            'meta'=>'MetaDataKey',
        );
    }
    
    /*
     * Return list of the Shemas by type
     */
    public function actionIndex()
    {
        $entities = array_keys($this->model_class_map);
        $coder = new CJSON();
        
        $response = $coder->encode($entities);

        Yii::trace($response);
        
        echo $response;
    }
    
    /*
        @type - type of the shema
        @id - id of the shema
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionView()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $type = Parameters::get('type');
        
        $ar = $this->getActiveRecordClass($type);
        if (!isset($ar))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_SHEMA_TYPE);
        
        $id = Parameters::get('id');
        $result = $ar::model()->findByPk($id);
        
        if (is_null($result))
            throw new APIException('Invalid ID value', APIResponseCode::API_INVALID_ID);
        
        $coder = new CJSON();
        $response = $result->encodeWithCoder($coder);
        
        echo $response;
    }
    
    /*
        @type - type of the shema
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionList()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $type = Parameters::get('type');
        
        $active_record = $this->getActiveRecordClass($type);
        if (!isset($active_record))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_SHEMA_TYPE);
            
        $result = $active_record::model()->findAll();
        $response = "";
        
        $coder = new CJSON();
        foreach ($result as $object) {
            $encoded_object = $object->encodeWithCoder($coder);

            if (strlen($response) > 1)
                $response .= ', ';

            $response .= $encoded_object;
        }

        echo "[$response]";
    }
    
    /*
        @type - type of the shema
        @id - id of the shema
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionUpdate()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $type = Parameters::get('type');

        $storage = DataStorageFactory::createStorage($type);
        
        if (is_null($storage))
            throw new APIException('Could not create data storage', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        try
        {
            $obj = DataModelFactory::createDataObjectWithType($type);
            $data = Parameters::getRaw('data', 'post');

            $attr = $storage->decodeResponse($data);
            $obj->setAttributes($attr);
            
            $storage->save($obj);
        }
        catch (Exception $e)
        {
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_UPDATE_ERROR);
        }
    }
    
    /*
        @type - type of the shema
        @data - data value
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionCreate()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $type = Parameters::get('type');
        
        $storage = DataStorageFactory::createStorage($type);

        if (is_null($storage))
            throw new APIException('Could not create data storage', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        try
        {
            $obj = DataModelFactory::createDataObjectWithType($type);
            $data = Parameters::getRaw('data', 'post');

            $attr = $storage->decodeResponse($data);
            $obj->setAttributes($attr);
            
            $storage->save($obj);
        }
        catch (Exception $e)
        {
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_CREATE_ERROR);
        }
    }
    
    /*
        @type - type of the shema
        @id - id of the shema
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionDelete()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $type = Parameters::get('type');
        $id = Parameters::get('id');
        
        $ar = $this->getActiveRecordClass($type);
        
        $record = $ar::model()->findByPk($id);
        if (!isset($record))
            throw new APIException('Invalid ID value', APIResponseCode::API_INVALID_ID);
        
        if ($record->delete() !== 1)
            throw new APIException('Could not delete resource object', APIResponseCode::API_SHEMA_DELETE_ERROR);
    }
    
    public function actionSearch()
    {
        echo 'SEARCH';
    }
    
    private function getActiveRecordClass($type)
    {
        return $this->model_class_map[$type];
    }
}
