<?php

require_once(dirname(__FILE__).'/ICoder.php');

class JsonCoder implements ICoder
{
    public function encode($object) {
        $json = new CJSON();
        return $json->encode($object);
    }
    
    public function decode($data) {
        $json = new CJSON();
        return $json->decode($data);
    }
}