<?php

include_once(dirname(__FILE__).'/../service/HttpRequest.php');

class RemoteResourceServiceImpl {
    private $service_url = null;
    
    public function __construct($service_url) {
        $this->service_url = $service_url;
    }
    
    public function getResourceTypeList() {
        $req = new HttpRequest();
        $req->setUrl($this->makeServiceApiUrl('/index.php?r=service/get&rtype=images&rid=list'));
        
        return $req->perform();
    }
    
    public function getResourceTypeById($id) {
        $req = new HttpRequest();
        $req->setUrl($this->makeServiceApiUrl('/index.php?r=service/get&rtype=images&rid='.$id));
        
        return $req->perform();
    }
    
    
    private function makeServiceApiUrl($api) {
        return $this->service_url.$api;
    }
}