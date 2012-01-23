<?php

include_once(dirname(__FILE__).'/../service/HttpRequest.php');

class RemoteResourceServiceImpl {
    const API_RESOURCE_BASE_URL = '/index.php/api/resource';
    const API_ENTITY_BASE_URL = '/index.php/api/service';
    
    const JSON_RESPONSE_FORMAT = 'json';
    const XML_RESPONSE_FORMAT = 'xml';
    
    private $service_url = null;
    private $format = null;
    
    public function __construct($service_url) {
        $this->service_url = $service_url;
        $this->format = RemoteResourceServiceImpl::JSON_RESPONSE_FORMAT;
    }
    
    public function getResourceTypeList($type) {
        $req = new HttpRequest();
        $req->setUrl($this->makeResourceApiUrl('/'.$type));
        
        $response = $req->perform();
        
        $items = array();
        if (strlen($response) > 0) {
            $coder = new CJSON();
            $items = $coder->decode($response);
            
            //check for error
        }
        
        return $items;
    }
    
    public function getResourceTypeById($id) {
        $req = new HttpRequest();
        $req->setUrl($this->makeResourceApiUrl('/images/'.$id));
        
        return $req->perform();
    }
    
    public function getEntityTypeList() {
        $req = new HttpRequest();
        $req->setUrl($this->makeEntitiesApiUrl('/index'));
        $response = $req->perform();
        
        $items = array();
        if (strlen($response) > 0) {
            $coder = new CJSON();
            $items = $coder->decode($response);
            
            //check for error
        }
        
        return $items;
    }
    
    public function getEntityList($type) {
        $req = new HttpRequest();
        $req->setUrl($this->makeEntitiesApiUrl('/'.$type));
        
        $resp = $req->perform();
//        die($resp);
        $coder = new CJSON();
        
        // $arr = array(
        //     "name"=>"test",
        //     "err"=>array("val","test",),);
        // 
        // die($coder->encode($arr));
        
        return $coder->decode($resp);
    }
    
    public function getEntityById($type, $id) {
        $req = new HttpRequest();
        $req->setUrl($this->makeEntitiesApiUrl('/'.$type.'/'.$id));
        $resp = $req->perform();
        
        $coder = new CJSON();
        return $coder->decode($resp);
    }
    
    public function saveEntity($type, $values, $id=0) {
        $coder = new CJSON();
        $data = $coder->encode($values);
        
        $req = new HttpRequest();
        if ($id == 0) {
            $req->setUrl($this->makeEntitiesApiUrl('/'.$type));
            $req->setParam('data', $data);
            $req->setParam('type', $type);
            $req->setMethod('POST');
        } else {
            $req->setUrl($this->makeEntitiesApiUrl('/'.$type.'/'.$id));
            $req->setParam('data', $data);
            $req->setMethod('POST');
        }
        
        $resp = $req->perform();
        return $coder->decode($resp);
    }
    
    public function removeEntity($type, $id) {
        $req = new HttpRequest();
        $req->setUrl($this->makeEntitiesApiUrl('/'.$type.'/'.$id));
        $req->setMethod('DELETE');
        
        $resp = $req->perform();
        echo $resp;
    }
    
    public function saveResource($type, $resource) {
        $coder = new CJSON();
        $data = $coder->encode($resource);
        
        $url = $this->makeResourceApiUrl('/'.$type);
//        die($url);
        
        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setParam('data', $data);
        $req->setParam('type', $type);
        $req->setMethod('POST');
        $resp = $req->perform();
        
        die($resp);
    }
    
    // ---------------------------------------------------------------------------
    //
    // Private functions
    //
    // ---------------------------------------------------------------------------
    
    private function makeResourceApiUrl($api) {
        return $this->service_url . RemoteResourceServiceImpl::API_RESOURCE_BASE_URL . $api . '.' . $this->format;
    }
    
    private function makeEntitiesApiUrl($api) {
        return $this->service_url . RemoteResourceServiceImpl::API_ENTITY_BASE_URL . $api . '.' . $this->format;
    }
}