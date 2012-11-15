<?php
    abstract class Connection {
        
        abstract function connect();
        
        abstract function query($dbConn, $query);
        
        abstract function preparedStatement($dbConn, $query, $params);
        
        abstract function close($connection);
        
        abstract function getRows($dbResult);
        
        abstract function fetchRow($dbResult);
        
        abstract function getColumnValue($dbResult, $columnName);
    }
?>