<?php

include_once 'database/DatabaseConnection.php';
include_once 'database/DatabaseRecordFactory.php';
include_once 'database/DatabaseFinderFactory.php';
include_once 'database/DatabaseWorker.php';

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
        return (DatabaseRecordFactory::createRecord($type) != false);
    }
    
    public function getResourcesCount($type) {
        $finder = DatabaseFinderFactory::finderByType($type);
        if ($finder == false)
            return false;
        return $finder->count();
    }
    
    public function getResources($type, $from, $count) {
        $finder = DatabaseFinderFactory::finderByType($type);
        if ($finder == false)
            return false;
        return $finder->findAll($from, $count);
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