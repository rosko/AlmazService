<?php

require_once(dirname(__FILE__).'/RemoteDataFinder.php');
require_once(dirname(__FILE__).'/../Object.php');
require_once(dirname(__FILE__).'/../../transformers/CoderFactory.php');

class RemoteObjectFinder extends RemoteDataFinder
{
    public function getMethodUrl($params = array()) {
        $baseUrl = 'http://resourceservice.local/index.php/api/service/object';
        
        if (isset($params['id']))
            $baseUrl .= '/'.$params['id'];
        
        return $baseUrl.'.json';
    }
    
    public function decodeResponse($response) {
        return CoderFactory::createCoder('json')->decode($response);
    }
    
    public function validateResponse($result) {
        return true;
    }
    
    public function createDataObject($attr) {
        $object = new Object();
        $object->setAttributes($attr);
        return $object;
    }
}