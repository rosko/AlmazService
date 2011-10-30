<?php

include_once 'database/DatabaseRecord.php';

class ClientApplication extends DatabaseRecord {
    public function __construct() {
        parent::__construct('ClientApplication', DatabaseRecord::INVALID_RECORD_ID);
    }
}

?>