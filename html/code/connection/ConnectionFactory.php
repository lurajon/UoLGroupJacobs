<?php

    include_once 'Connection.php';
    include_once 'OdbcConnection.php';

    class ConnectionFactory {
        
        static function getConnection($type) {
            
            switch($type) {
                case 'odbc' :
                    return new OdbcConnection();
                default :
                    return null;
            }
        }
    }
?>