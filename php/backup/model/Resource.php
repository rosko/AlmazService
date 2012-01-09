<?php

include_once 'database/DatabaseRecord.php';

class Resource extends DatabaseRecord {
    public function __construct() {
        parent::__construct('Resource', DatabaseRecord::INVALID_RECORD_ID);
    }
    
    public function getTypeName() {
        $fined = DatabaseFinder::
    }
    
    
    
    public function getObjectValue() {
        // Get Text object for current resource
    }
    
    public function getObjectMetaData() {
        // return all metadata for resource object
    }
    
    public function getObjectMetaData($metaDataName) {
    }
    
    public function setObjectMetaData($metaDataName, $metaDataValue) {
    }
    
    public function removeObjectMetaData($metaDataName) {
        
    }
    
    
    
    public function getMetaData() {
        // return array
    }
    
    public function getMetaData($metaDataName) {
        
    }
    
    public function setMetaData($metaDataName, $metaDataValue) {
        
    }
    
    public function removeMetaData($metaDataName) {
        
    }
}

?>