<?php

class HttpRequest {
    
    private $url = null;
    private $params = array();
    private $method = null;
    
    public function __construct() {
        $this->method = 'GET';
    }
    
    public function setUrl($url) {
        $this->url = $url;
    }
    
    public function getUrl($url) {
        return $this->url;
    }
    
    public function setParams($params) {
        $this->params = $params;
    }
    
    public function setParam($param_name, $param_value) {
        $this->params[$param_name] = $param_value;
    }
    
    public function getParam($param_name) {
        return $this->params[$param_name];
    }
    
    public function perform() {
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $res = curl_exec($curl);
        
        curl_close($curl);
        
        return $res;
    }
}