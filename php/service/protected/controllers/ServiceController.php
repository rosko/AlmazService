<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');
include_once(dirname(__FILE__).'/APIResponseCode.php');

class ServiceController
{
    private $model_class_map = array();
    
    public function __construct() {
        $this->model_class_map = array(
            'class'=>'ResourceType',
            'object'=>'Object',
            'meta'=>'MetaDataKey',
        );
    }
    
    /*
        Return list of the Shemas by type
    */
    public function actionIndex() {
        $entities = array_keys($this->model_class_map);
        $coder = new CJSON();
        
        $response = $coder->encode($entities);
        
        echo $response;
    }
    
    /*
        @type - type of the shema
        @id - id of the shema
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionView() {
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
    public function actionList() {
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
    public function actionUpdate() {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $type = Parameters::get('type');

        $ar = $this->getActiveRecordClass($type);
        if (!isset($ar))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_SHEMA_TYPE);
        
        $id = Parameters::get('id');
        
        $record = $ar::model()->findByPk($id);
        if (is_null($record))
            throw new APIException('Invalid ID value', APIResponseCode::API_INVALID_ID);
        
        $data = Parameters::getRaw('data', 'POST');
        
        $coder = new CJSON();
        $value = $coder->decode($data, false);
        
        foreach ($value as $attr_name => $attr_value) {
            if ($record->hasAttribute($attr_name) && $attr_name !== 'id') {
                $record->setAttribute($attr_name, $attr_value);
            }
        }
        
        if (!$record->save())
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_UPDATE_ERROR);
    }
    
    /*
        @type - type of the shema
        @data - data value
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionCreate() {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $type = Parameters::get('type');
        
        $active_record = $this->getActiveRecordClass($type);
        if (!isset($active_record))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_SHEMA_TYPE);
        
        $data = Parameters::getRaw('data', 'post');
        
        $coder = new CJSON();
        $value = $coder->decode($data, false);
        
        if (is_null($value))
            throw new APIException('Invalid ID value', APIResponseCode::API_INVALID_ID);
        
        $attrs = get_object_vars($value);
        
        $object = new $active_record;
        foreach ($attrs as $attr_name => $attr_value) {
            if ($object->hasAttribute($attr_name)) {
                $object->setAttribute($attr_name, $attr_value);
            }
        }
        
        if (!$object->save())
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_DELETE_ERROR);
    }
    
    /*
        @type - type of the shema
        @id - id of the shema
        @format - response format
        
        @return - Formatted plain text response
    */
    public function actionDelete() {
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
    
    public function actionSearch() {
        echo 'SEARCH';
    }
    
    private function getActiveRecordClass($type) {
        return $this->model_class_map[$type];
    }
}
