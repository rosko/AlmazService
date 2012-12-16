<?php

class FinderFactory
{
    private $classNames;
    private static $_sharedFactory = null;

    public function __construct() {
        $classNames = array();
        
        // Temporary. Need to remove from it and call registration method from each of finder classes.
        $this->registerClassName("RemoteClassFinder", "class");
        $this->registerClassName("RemotePropertyFinder", "meta");
        $this->registerClassName("RemoteObjectFinder", "object");
        $this->registerClassName("RemoteResourceFinder", "resource");
        $this->registerClassName("RemoteUserFinder", "user");
        $this->registerClassName("RemoteClientAppFinder", "apps");
    }

    public function registerClassName($className, $type) {
        $this->classNames[$type] = $className;
    }
    
    public function unregisterClassName($className) {
        foreach ($this->classNames as $type => $name)
            if ($className == $name) {
                unset($this->classNames[$type]);
                break;
            }
    }

    public function getClassNameByType($type) {
        return $this->classNames[$type];
    }

    public static function factory() {
        if (self::$_sharedFactory == null)
            self::$_sharedFactory = new FinderFactory();
        return self::$_sharedFactory;
    }

    public static function createFinderWithType($type) {
        $className = self::factory()->getClassNameByType($type);
        if (!isset($className) || is_null($className))
            return null;

        return self::createFinder($className);
    }
    
    public static function createFinder($className) {
        if (!class_exists($className)) {
            $classFilePath = dirname(__FILE__).'/'.$className.'.php';
            if (!file_exists($classFilePath))
                throw new Exception('Could not find the Finder class for type='.$className);
            require_once($classFilePath);
        }
        return new $className();
    }
}