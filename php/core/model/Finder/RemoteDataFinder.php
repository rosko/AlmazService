<?php

require_once(dirname(__FILE__).'/AbstractFinder.php');
require_once(dirname(__FILE__) . '/../../RemoteException.php');
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
        if (isset($result['error']))
            throw new RemoteException($result['error']);
        
        return $this->createResultDataSet($result);
    }
    
    public function findById($id) {
        $req = new HttpRequest();
        
        $url = $this->getMethodUrl(array('id'=>$id));
        $req->setUrl($url);
        $response = $req->perform();
        
        $result = $this->decodeResponse($response);
        if (isset($result['error']))
            throw new RemoteException($result['error']);
        
        $object = null;
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
        if (isset($result['error']))
            throw new RemoteException($result['error']);
        
        return $this->createResultDataSet($result);
    }
    
    private function createResultDataSet($result) {
        $dataSet = array();
        if ($this->validateResponse($result) && count($result) > 0) {
            foreach ($result as $object) {
                $dataSet[] = $this->createDataObject($object);
            }
        }
        
        return $dataSet;
    }
}