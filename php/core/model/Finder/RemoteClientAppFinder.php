<?php

include_once(dirname(__FILE__).'/RemoteDataFinder.php');
include_once(dirname(__FILE__).'/../../transformers/CoderFactory.php');

class RemoteClientAppFinder extends RemoteDataFinder
{
    public function getMethodUrl($params = array()) {
//        $baseUrl = 'http://resourceservice.local/index.php/api/service/class';
//
//        if (isset($params['id']))
//            $baseUrl .= '/'.$params['id'];
//
//        return $baseUrl.'.json';
    }

    public function decodeResponse($response) {
        return CoderFactory::createCoder('json')->decode($response);
    }

    public function validateResponse($result) {
        return true;
    }

    public function createDataObject($object) {
//        $class = new ClassName();
//        $class->setAttributes($object);
//        return $class;
    }
}