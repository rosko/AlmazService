<?php

include_once 'database/DatabaseRecord.php';

class ResourceMetaData extends DatabaseRecord {
    private $resource;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function resource() {
        //Load resource by resourceId
        return $this->resource;
    }
}

?>