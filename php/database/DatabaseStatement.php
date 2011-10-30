<?php

/*
 DatabaseStatement class
*/
class DatabaseStatement {
    private $stmt;
    private $query;
    private $connection;
    private $result = null;
    
    public function __construct($connection, $query) {
        $this->connection = $connection;
        $this->query = $query;
    }
    
    public function exec() {
        $this->result = $this->connection->exec($this->query);
    }
    
    public function getLastInsertId() {
        return mysql_insert_id();
    }
    
    public function hasResult() {
        return ($this->result != null);
    }
    
    public function getRowCount() {
        return mysql_num_rows($this->result);
    }
    
    public function fetchAssocNextRow() {
        return mysql_fetch_assoc($this->result);
    }
    
    public function fetchIndexedNextRow() {
        return mysql_fetch_array($this->result, MYSQL_NUM);
    }
}

?>