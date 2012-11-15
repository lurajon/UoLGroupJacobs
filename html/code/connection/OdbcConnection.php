<?php

    include_once 'Connection.php';
    
    class OdbcConnection extends Connection {
    
        function connect() {
            return odbc_connect('uol-odb', '', '');
        }
        
        function query($dbConn, $query) {
            return odbc_exec($dbConn, $query);
        }
        
        /**
         * Not supported on UoL Student Server..
         */
        function preparedStatement($dbConn, $query, $params) {
            $res = odbc_prepare($dbConn, $query);
            
            odbc_execute($res, $params);
            
            return $res;
        }
        
        function close($connection) {
            odbc_close($connection);
        }
        
        function getRows($dbResult) {
            return odbc_num_rows($dbResult);
        }
        
        function fetchRow($dbResult) {
            return odbc_fetch_row($dbResult);   
        }
        
        function getColumnValue($dbResult, $columnName) {
            return odbc_result($dbResult, $columnName);   
        }
    }
?>