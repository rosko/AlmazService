<?php

include_once(dirname(__FILE__).'/RemoteResourceServiceImpl.php');

class ResourceService {
    private $impl = null;
    
    public function __construct($service_url) {
        $this->impl = new RemoteResourceServiceImpl($service_url);
    }
    
    public function __call($method, $params) {
        if (method_exists($this->impl, $method))
            return call_user_func_array(array(&$this->impl, $method), $params);
        
        echo "ResourceService: method $method not implemented";
    }
}
