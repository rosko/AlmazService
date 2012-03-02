<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once(dirname(__FILE__).'/../../../../core/model/Finder/AbstractFinder.php');
include_once(dirname(__FILE__).'/../../../../core/transformers/CoderFactory.php');

class YiiDataFinder implements AbstractFinder
{
    protected $model = null;
    
    public function prepareObjectAttributes($record) {
        
    }
    
    public function createDataObject($attr) {
        
    }
    
    public function findAllInDatabase() {
        return $this->model->findAll();
    }
    
    public function __construct($model) {
        $this->model = $model;
    }
    
    public function findAll() {
        $result = $this->findAllInDatabase();
        
        $dataSet = array();
        foreach ($result as $record) {
            $attr = $this->prepareObjectAttributes($record);
            $dataSet[] = $this->createDataObject($attr);
        }
        
        return $dataSet;
    }
    
    public function findById($id) {
        $record = $this->model->findByPk($id);
        
        $attr = $this->prepareObjectAttributes($record);
        $object = $this->createDataObject($attr);
        
        return $object;
    }
    
    public function findWithOptions($options) {
        
    }
    
    private function decodeResponse($response) {
        return CoderFactory::createCoder('json')->decode($response);
    }
}

?>
