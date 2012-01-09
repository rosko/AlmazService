<?php

include_once 'database/DatabaseRecord.php';

class Resource extends DatabaseRecord {
    public function __construct() {
        parent::__construct('Resource', DatabaseRecord::INVALID_RECORD_ID);
    }
}

?>