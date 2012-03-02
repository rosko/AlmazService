<?php

require_once(dirname(__FILE__).'/RemoteDataStorage.php');
require_once(dirname(__FILE__).'/../Resource.php');
require_once(dirname(__FILE__).'/../../transformers/CoderFactory.php');

class RemoteResourceStorage extends RemoteDataStorage
{
    private $type = null;
    
    public function getMethodUrl($params = array()) {
        $baseUrl = 'http://resourceservice.local/index.php/api/resource/'.$this->type;
        
        if (isset($params['id']))
            $baseUrl .= '/'.$params['id'];
        
        return $baseUrl.'.json';
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function validateResponse($result) {
        return true;
    }
}