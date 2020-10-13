<?php
class DbConnection {

	protected $serverName = "DELL-PC\SQLEXPRESS";
	protected $connectionInfo = array( "Database"=>"NH_STEAK_PIZZA","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
	protected $conn;

	function __construct() {
			$this->conn =  sqlsrv_connect( $this->serverName, $this->connectionInfo) or die("Database Connection Error"."<br>". mssql_get_last_message()); 
    }
}

class GoldenLotus extends DbConnection{
	public function layMaNV() {
		echo $sql = "SELECT *  FROM [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien]";
		try{
			$rs = sqlsrv_query($this->conn, $sql);;
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
}