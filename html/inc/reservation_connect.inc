<?php
	class BaseConnection {
	protected $dbSource, $dbUser, $dbPassword;
	protected $dbConn = NULL;

	function openConnection() {

		$this->dbSource = "Driver={Microsoft Access Driver (*.mdb)}; DBQ=d:\\inetpub\\wwwroot\\projects\\group60\\db\\uol_hotel.mdb"; //student server db
		
		$this -> dbUser = "";
		$this -> dbPassword = "";

		if (!$this -> dbConn)
			$this -> dbConn = odbc_connect($this -> dbSource, $this -> dbUser, $this -> dbPassword);
		if (!$this -> dbConn) {
			return FALSE;
		} else {
			return $this -> dbConn;
		}
	}

	function closeConnection($openConnection) {
		odbc_close($openConnection);
	}

	function queryDB($openConnection, $queryString) {
		return odbc_exec($openConnection, $queryString);
	}

	function getTableRow($resultSet) {
		return odbc_fetch_row($resultSet);
	}

	function getValue($resultSet, $tableColumn) {
		return odbc_result($resultSet, $tableColumn);
	}

}
?>