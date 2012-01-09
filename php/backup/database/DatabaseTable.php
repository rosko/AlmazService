<?php

include_once 'database/DatabaseConnection.php';

class DatabaseTable {
    private static $_table_cache_ = array();
    private $name;
    private $fields = array();
    
    /* Search table in cache and create it if not founded */
    public static function getTableWithName($tableName) {
        foreach (self::$_table_cache_ as $name => $table) {
            if (strcmp($tableName, $name) == 0) {
                return $table;
            }
        }
        return new DatabaseTable($tableName);
    }
    
    /* Constructor */
    public function __construct($tableName) {
        $this->name = $tableName;
        $this->load();
        self::$_table_cache_[$tableName] = $this;
    }
    
    public function getFields() { 
        return $this->fields;
    }
    
    public function getName() {
        return $this->name;
    }
    
    /* Load table info from current connection */
    private function load() {
        $stmt = DatabaseConnection::sharedConnection()->statement('show columns from ' . $this->name);
        $stmt->exec();
        while ($record = $stmt->fetchIndexedNextRow()) {
            $this->fields[] = $record[0];
        }
    }
}

?>