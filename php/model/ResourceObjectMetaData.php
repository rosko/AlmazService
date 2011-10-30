<?php

include_once 'database/DatabaseRecord.php';

class ResourceObjectMetaData extends DatabaseRecord {
    public function __construct() {
        parent::__construct('ResourceObjectMetaData', DatabaseRecord::INVALID_RECORD_ID);
    }
}

?>