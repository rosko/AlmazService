<?php

include_once 'database/DatabaseRecord.php';

class TextObject extends DatabaseRecord {
    public function __construct() {
        parent::__construct('TextObject', DatabaseRecord::INVALID_RECORD_ID);
    }
}

?>