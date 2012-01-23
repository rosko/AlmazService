<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');

class ServiceController {
    private $model_class_map = array();
    
    public function __construct() {
        $this->model_class_map = array(
            'class'=>'ResourceType',
            'object'=>'Object',
            'meta'=>'MetaDataKey',
        );
    }
    
    public function actionIndex() {
        $entities = array_keys($this->model_class_map);
        $coder = new CJSON();
        
        $response = $coder->encode($entities);
        
        echo $response;
    }
    
    public function actionView() {
        $type = Parameters::get('type');
        
        $ar = $this->getActiveRecordClass($type);
        if (isset($ar))
        {
            $id = Parameters::get('id');
            $result = $ar::model()->findByPk($id);
            
            $coder = new CJSON();
            
            $response = $result->encodeWithCoder($coder);
            //$response = $coder->encode($result);
            
            echo $response;
        }
    }
    
    public function actionList() {
        $type = Parameters::get('type');
        
        $active_record = $this->getActiveRecordClass($type);
        if (isset($active_record))
        {
            $result = $active_record::model()->findAll();
            $response = "";
            
            $coder = new CJSON();
            foreach ($result as $object) {
                $encoded_object = $object->encodeWithCoder($coder);
                
                if (strlen($response) > 1)
                    $response .= ', ';
                
                $response .= $encoded_object;
            }
            
//            $response = $coder->encode($result);
            
            echo "[$response]";
        }
    }
    
    public function actionUpdate() {
        $type = Parameters::get('type');

        $ar = $this->getActiveRecordClass($type);
        if (isset($ar)) {
            echo 'isset($active_record)';
            
            $id = Parameters::get('id');
            $record = $ar::model()->findByPk($id);
            if (!is_null($record)) {
                $data = Parameters::getRaw('data', 'POST');
                
                $coder = new CJSON();
                $value = $coder->decode($data, false);
                
                foreach ($value as $attr_name => $attr_value) {
                    if ($record->hasAttribute($attr_name)) {
                        $record->setAttribute($attr_name, $attr_value);
                    }
                }
                
                $record->save();
            }
        }
    }
    
    public function actionCreate() {
        $type = Parameters::get('type', 'post');

        $active_record = $this->getActiveRecordClass($type);
        if (isset($active_record)) {
            $data = Parameters::getRaw('data', 'post');
            
            $coder = new CJSON();
            $value = $coder->decode($data, false);
            
            if (is_null($value)) {
                echo 'Error: Invalid data'; 
            }
            
            $attrs = get_object_vars($value);
            
            $object = new $active_record;
            foreach ($attrs as $attr_name => $attr_value) {
                if ($object->hasAttribute($attr_name)) {
                    $object->setAttribute($attr_name, $attr_value);
                }
            }
            
            $object->save();
        } else {
            echo 'Invalid type';
        }
    }
    
    public function actionDelete() {
        if (!Parameters::hasParam('type'))
            die('TYPE parameter is absent');

        if (!Parameters::hasParam('id'))
            die('ID parameter is absent');
        
        $type = Parameters::get('type');
        $id = Parameters::get('id');
        
        $ar = $this->getActiveRecordClass($type);
        
        $record = $ar::model()->findByPk($id);
        if (!isset($record))
            die("Invalid ID");
        
        echo $record->delete();
    }
    
    public function actionSearch() {
        echo 'SEARCH';
    }
    
    private function getActiveRecordClass($type) {
        return $this->model_class_map[$type];
    }
}
