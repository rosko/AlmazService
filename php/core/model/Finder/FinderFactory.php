<?php

require_once(dirname(__FILE__).'/RemoteClassFinder.php');
require_once(dirname(__FILE__).'/RemotePropertyFinder.php');
require_once(dirname(__FILE__).'/RemoteObjectFinder.php');

class FinderFactory
{
    public static function createFinderWithType($type) {
        if ($type == 'class')
            $finder = FinderFactory::createFinder('RemoteClassFinder');
        else if ($type == 'meta')
            $finder = FinderFactory::createFinder('RemotePropertyFinder');
        else if ($type == 'object')
            $finder = FinderFactory::createFinder('RemoteObjectFinder');
        else
            $finder = null;
        return $finder;
    }
    
    public static function createFinder($className) {
        if (!class_exists($className))
            throw new Exception('Could not find the Finder class for type='.$className);
        return new $className();
    }
}