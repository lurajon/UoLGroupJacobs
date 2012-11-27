<?php
	class BaseConnection {
	protected $dbSource, $dbUser, $dbPassword;
	protected $dbConn = NULL;

	function openConnection() {

		//$this -> dbSource = "Driver={Microsoft Access Driver (*.mdb)}; DBQ=c:\\users\\zmanowsky\\documents\\github\\uolgroupjacobs\\html\\db\\uol_hotel.mdb";
		// local w8 mac
		$this -> dbSource = "Driver={Microsoft Access Driver (*.mdb)}; DBQ=c:\\users\\zmc\\documents\\github\\uolgroupjacobs\\html\\db\\uol_hotel.mdb";
		// local w8 work
		//$this->dbSource = "Driver={Microsoft Access Driver (*.mdb)}; DBQ=c:\\inetpub\\uniroot\\db\\uol_hotel.mdb"; // firma
		//  $this->$dbSource = "Driver={Microsoft Access Driver (*.mdb)}; DBQ=d:\\inetpub\\wwwroot\\projects\\group60\\db\\uol_hotel.mdb"; //student
		//$this->$dbSource = "Driver=SQLite3 Driver;Database=/Users/zmanowsky/uol-group-jacobs/UoLGroupJacobs/html/db/uol_hotel.sqlite";
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