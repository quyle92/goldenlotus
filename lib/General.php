<?php

class General {

	/* Properties */
    private $conn;

    /* Get database access */
    protected function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
		$this->includeFile();//include_once('../helper/custom-function.php');
	}

	protected function includeFile() {
		include_once(__DIR__ . '/../helper/custom-function.php');
	}

	protected function taoView( $ma_quay )
	{	
		call_user_func_array( array( $this, $ma_quay ), [] );
	}

	protected function SPA() {

		$sql = "IF OBJECT_ID('[SPAView]','v') IS NOT NULL BEGIN DROP view  [SpaView] END ;";//(1)
		$sql_1 = "CREATE VIEW  [SPAView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE TenQuay = 'SPA'
				";//(1)
		try
		{
			$this->conn->query($sql);
			$this->conn->query($sql_1);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	protected function SNACKBAR() {
		$sql = "IF OBJECT_ID('[SNACKBARView]','v') IS NOT NULL BEGIN DROP view  [SNACKBARView] END ;";
		$sql_1 = "CREATE VIEW  [SNACKBARView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE TenQuay = 'SNACKBAR'
				";
		try
		{
			$this->conn->query($sql);
			$this->conn->query($sql_1);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	protected function CAFE() {
		$sql = "IF OBJECT_ID('[CAFEView]','v') IS NOT NULL BEGIN DROP view  [CAFEView] END ;";
		$sql_1 = "CREATE VIEW  [CAFEView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE TenQuay = 'CAFE'
				";
		try
		{
			$this->conn->query($sql);
			$this->conn->query($sql_1);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	protected function GAME() {
		$sql = "IF OBJECT_ID('[GAMEView]','v') IS NOT NULL BEGIN DROP view  [GAMEView] END ;";
		$sql_1 = "CREATE VIEW  [GAMEView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE TenQuay = 'GAME'
				";
		try
		{
			$this->conn->query($sql);
			$this->conn->query($sql_1);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	protected function RESTAURANT() {
		$sql = "IF OBJECT_ID('[RESTAURANTView]','v') IS NOT NULL BEGIN DROP view  [RESTAURANTView] END ;";
		$sql_1 = "CREATE VIEW  [RESTAURANTView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE TenQuay = 'RESTAURANT'
				";
		try
		{
			$this->conn->query($sql);
			$this->conn->query($sql_1);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


}

/**Note**/
//(1): have to send the script to the server in small batches, esle error will happen. ref: https://stackoverflow.com/a/53462790/11297747