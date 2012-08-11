<?php

require_once(dirname(__FILE__).'/AbstractDataStorage.php');
require_once(dirname(__FILE__).'/../../http/HttpRequest.php');
require_once(dirname(__FILE__).'/../../transformers/CoderFactory.php');

abstract class RemoteDataStorage implements AbstractDataStorage
{
    public abstract function getMethodUrl($params = array());
    
    public abstract function validateResponse($result);
    
    public function decodeResponse($response) {
        return CoderFactory::createCoder('json')->decode($response);
    }
    
    public function encodeResponse($array) {
        return CoderFactory::createCoder('json')->encode($array);
    }
    
    public function save($object) {
        if ($object->id == 0) {
            return $this->insert($object);
        }
        return $this->update($object);
    }
    
    public function remove($object) {
        if ($object->id == 0)
            return false;
        
        $url = $this->getMethodUrl(array('id'=>$object->id));
        
        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setMethod('DELETE');
        
        $response = $req->perform();
        
        $result = $this->decodeResponse($response);
        return $this->validateResponse($result);
    }
    
    private function insert($object) {
        $attr = $object->getAttributes();
        
        $url = $this->getMethodUrl();
        
        $data = $this->encodeResponse($attr);
        
        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setParam('data', $data);
        $req->setMethod('POST');
        $response = $req->perform();
        
        $result = $this->decodeResponse($response);
        $isValid = $this->validateResponse($result);
        
        if ($isValid)
            $object->id = $result['id'];
        
        return $isValid;
    }
    
    private function update($object) {
        $attr = $object->getAttributes();
        $data = $this->encodeResponse($attr);
        
        $url = $this->getMethodUrl(array('id'=>$object->id));

        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setParam('data', $data);
        $req->setMethod('POST');
        $response = $req->perform();
        
        $result = $this->decodeResponse($response);
        return $this->validateResponse($result);
    }
}