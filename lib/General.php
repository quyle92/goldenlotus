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

	protected function SPA_ALL() {

		$sql = "IF OBJECT_ID('[SPA_ALLView]','v') IS NOT NULL BEGIN DROP view  [SPA_ALLView] END ;";//(1)
		$sql_1 = "CREATE VIEW  [SPA_ALLView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE TenQuay IN ('SPA', 'CAFE', 'GAME', 'SNACKBAR')
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

	protected function GYM() {
		$sql = "IF OBJECT_ID('[GYMView]','v') IS NOT NULL BEGIN DROP view  [GYMView] END ;";
		 $sql_1 = "CREATE VIEW  [GYMView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE TenQuay = 'GYM'
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

	protected function checkUser( $tenSD ) 
	{	
		 $tenSD = htmlentities(trim(strip_tags($tenSD)),ENT_QUOTES,'utf-8');

		$sql = "DECLARE @tenSD varchar(max)
		SET @tenSD = :tenSD
		SELECT * from [tblDSNguoiSD] where [TenSD] = @tenSD";
		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tenSD', $tenSD);
			
			$stmt->execute();
			$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			return ( ! $rs ) ? false : true;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
}

/**Note**/
//(1): have to send the script to the server in small batches, esle error will happen. ref: https://stackoverflow.com/a/53462790/11297747