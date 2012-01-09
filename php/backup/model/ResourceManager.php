<?php

include_once 'database/DatabaseConnection.php';
include_once 'database/DatabaseRecordFactory.php';
include_once 'database/DatabaseFinderFactory.php';
include_once 'database/DatabaseWorker.php';
include_once 'database/DatabaseRecordFactory.php';

class ResourceManager {
    
    private static $__manager__;
    public static function manager() {
        if (!isset($__manager__))
            $__manager__ = new ResourceManager();
        return $__manager__;
    }
    
    private $connection;
    
    public function __construct() {
        $this->connection = DatabaseConnection::sharedConnection('127.0.0.1', 'ResourceManager', 'root', '');
    }
    
    public function __destruct() {
        unset($this->connection);
    }
    
    public function validateResourceType($type) {
        return (DatabaseRecordFactory::factory()->createObject($type) != false);
    }
    
    public function getResourcesCount($type) {
        $finder = DatabaseFinderFactory::finderByType($type);
        if ($finder == false)
            return false;
        return $finder->count();
    }
    
    public function getResources($type, $from, $count) {
        /*
        
        SELECT * FROM ResourceObject as ro
        INNER JOIN Resource AS r ON r.id = ro.resourceID AND r.type = $resourceTypeID
        
        SELECT * FROM Resource AS r
        INNER JOIN ResourceType AS rt ON r.type = rt.id AND rt.name = $type
        
        */
        
        
        /*
            $finder = ResourceFinder::finder();
            
            $resources = $finder->findWithType($type, $from, $count);
        */
        $finder = new DatabaseFinder($this->connection);
//        $finder = DatabaseFinderFactory::finderByType($type);
        if ($finder == false)
            return false;
        return $finder->findAll($type, $from, $count);
    }
    
    public function getResourceById($type, $id) {
        $finder = DatabaseFinderFactory::finderByType($type);
        if ($finder == false)
            return false;
        return $finder->findById($id);
    }
    
    public function saveResource($resource) {
        $worker = new DatabaseWorker($this->connection);
        if ($resource->isNewRecord())
            $worker->insert($resource);
        else
            $worker->update($resource);
    }
    
    public function removeResource($resource) {
        $worker = new DatabaseWorker($this->connection);
        $worker->delete($resource);
    }
}

?>