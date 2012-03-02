<?php

include_once(dirname(__FILE__).'/RemoteDataFinder.php');
include_once(dirname(__FILE__).'/../Resource.php');
include_once(dirname(__FILE__).'/../../transformers/CoderFactory.php');

class RemoteResourceFinder extends RemoteDataFinder
{
    private $type = null;
    private $devkey = null;
    
    public function getMethodUrl($params = array()) {
        $baseUrl = 'http://resourceservice.local/index.php/api/resource/'.$this->type;
        
        if (isset($params['id']))
            $baseUrl .= '/'.$params['id'];
        
        return $baseUrl.'.json?devkey='.$this->devkey;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function setDevKey($devkey) {
        $this->devkey = $devkey;
    }
    
    public function decodeResponse($response) {
        return CoderFactory::createCoder('json')->decode($response);
    }
    
    public function validateResponse($result) {
        return true;
    }
    
    public function createDataObject($object) {
        $resource = new Resource;
        $resource->setAttributes($object);
        return $resource;
    }
}