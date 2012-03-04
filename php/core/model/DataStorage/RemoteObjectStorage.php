<?php

require_once(dirname(__FILE__).'/RemoteDataStorage.php');
require_once(dirname(__FILE__).'/../Class.php');
require_once(dirname(__FILE__).'/../../transformers/CoderFactory.php');

class RemoteObjectStorage extends RemoteDataStorage
{
    public function getMethodUrl($params = array()) {
        $baseUrl = 'http://resourceservice.local/index.php/api/service/object';
        
        if (isset($params['id']))
            $baseUrl .= '/'.$params['id'];
        
        return $baseUrl.'.json';
    }
    
    public function validateResponse($result) {
        return true;
    }
}