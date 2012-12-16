<?php

class Factory
{
    private $types = array();
    
    public static function factory()
    {
        $class = get_called_class();
        if (isset($class))
            return new $class;
        return new Factory();
    }
    
    public function __construct()
    {
    }
    
    public function registerType($type, $className)
    {
        if (!isset($this->types[$type]))
            $this->types[$type] = $className;
    }
    
    public function createObject($type)
    {
        $className = $this->getClassName($type);
        if (isset($className))
            return new $className;
        return NULL;
    }

    public function getClassName($type)
    {
        return $this->types[$type];
    }
}

?>