<?php

include_once 'database/DatabaseRecord.php';

class ResourceType extends DatabaseRecord {
    public function __construct() {
        parent::__construct('ResourceType', DatabaseRecord::INVALID_RECORD_ID);
    }
}

?>