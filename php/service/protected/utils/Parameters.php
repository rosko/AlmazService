<?php

class Parameters {
    public static function _GET() {
        return $_GET;
    }
    
    public static function _POST() {
        return $_POST;
    }
    
    public static function getRaw($param_name, $type = 'GET') {
        if ($type == 'GET')
            $arg_val = $_GET[$param_name];
        else if ($type == 'PUT') {
            
            $request = Yii::app()->getRequest();
            
            $arg_val = $request->getPut('data');
        }
        else
            $arg_val = $_POST[$param_name];
        return $arg_val;
    }
    
    public static function get($param_name, $type = 'GET') {
        $arg_val = Parameters::getRaw($param_name, $type);
        
        return mysql_escape_string($arg_val);
    }
    
    public static function getInt($param_name) {
        return intval(Parameters::get($param_name));
    }
    
    public static function getUrlArgByName($param_name) {
        return Parameters::get($param_name);
    }
    
    public static function hasParam($param_name, $type = 'GET') {
        if ($type == 'GET')
            return array_key_exists($param_name, $_GET);
        return array_key_exists($param_name, $_POST);
    }
}