<?php

include_once 'database/DatabaseRecordFactory.php';
include_once 'database/DatabaseStatement.php';

class DatabaseFinder {
    private $connection = null;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function findById($type, $id) {
        $record = DatabaseRecordFactory::factory()->createObject($type);
        $query = "SELECT * FROM " . $record->getTable()->getName() . " WHERE id=" . mysql_escape_string($id);
        
        $stmt = new DatabaseStatement($this->connection, $query);
            
        if ($stmt->exec() ) {
            /* Fetch row data and fill record
            */
            $row = $stmt->fetchAssocNextRow();
            foreach ($row as $field => $value) {
                $record->__set($field, $value);
            }
        }
        
        return $record;
    }
    
    public function findAll($type, $from, $count) {
        $record = DatabaseRecordFactory::factory()->createObject($type);
        $query = "SELECT * FROM " . $record->getTable()->getName() . " LIMIT (" . $from . "," . $count . ")";
        
        $records = array();
        
        $stmt = new DatabaseStatement($this->connection, $query);
        if ($stmt->exec()) {
            while ($row = $stmt->fetchAssocNextRow()) {
                $record = DatabaseRecordFactory::factory()->createObject($type);
                foreach ($row as $field => $value) {
                    $record->__set($field, $value);
                }
                $records[] = $record;
            }
        }
        
        return $records;
    }
}

?>