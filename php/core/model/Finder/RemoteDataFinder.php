<?php

require_once(dirname(__FILE__).'/AbstractFinder.php');
require_once(dirname(__FILE__) . '/../../http/HttpRequest.php');

abstract class RemoteDataFinder implements AbstractFinder
{
    public abstract function getMethodUrl($params = array());
    public abstract function decodeResponse($response);
    public abstract function validateResponse($result);
    public abstract function createDataObject($object);
    
    public function findAll() {
        $req = new HttpRequest();
        
        $url = $this->getMethodUrl();
        $req->setUrl($url);
        $response = $req->perform();
        
        $result = $this->decodeResponse($response);
        
        $dataSet = array();
        if ($this->validateResponse($result)) {
            foreach ($result as $object) {
                $dataSet[] = $this->createDataObject($object);
            }
        }
        
        return $dataSet;
    }
    
    public function findById($id) {
        $req = new HttpRequest();
        
        $url = $this->getMethodUrl(array('id'=>$id));
        $req->setUrl($url);
        
        $response = $req->perform();
        $result = $this->decodeResponse($response);
        
        $object = nil;
        if ($this->validateResponse($result)) {
            $object = $this->createDataObject($result);
        }
        
        return $object;
    }
    
    public function findWithOptions($options) {
        $req = new HttpRequest();

        $url = $this->getMethodUrl($options);
        $req->setUrl($url);
        $req->setParams($options);
        $response = $req->perform();
        
        $result = $this->decodeResponse($response);
        
        $dataSet = array();
        if ($this->validateResponse($result)) {
            foreach ($result as $object) {
                $dataSet[] = $this->createDataObject($object);
            }
        }
        
        return $dataSet;
    }
}