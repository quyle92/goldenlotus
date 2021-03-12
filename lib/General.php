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

	protected function Spa() {

		$sql = "IF OBJECT_ID('[SpaView]','v') IS NOT NULL BEGIN DROP view  [SpaView] END ;";//(1)
		$sql_1 = "CREATE VIEW  [SpaView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE Ma = '2014201'
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

	protected function createSnackBarView() {
		$sql = "IF OBJECT_ID('[SnackBarView]','v') IS NOT NULL BEGIN DROP view  [SnackBarView] END ;";
		$sql_1 = "CREATE VIEW  [SnackBarView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE Ma = '2014201'
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

	protected function createCafeteriaView() {
		$sql = "IF OBJECT_ID('[CafeteriaView]','v') IS NOT NULL BEGIN DROP view  [CafeteriaView] END ;";
		$sql_1 = "CREATE VIEW  [CafeteriaView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE Ma = '2014201'
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

	protected function createGameView() {
		$sql = "IF OBJECT_ID('[GameView]','v') IS NOT NULL BEGIN DROP view  [GameView] END ;";
		$sql_1 = "CREATE VIEW  [GameView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE Ma = '2014201'
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

	protected function createNhaHangView() {
		$sql = "IF OBJECT_ID('[NhaHangView]','v') IS NOT NULL BEGIN DROP view  [NhaHangView] END ;";
		$sql_1 = "CREATE VIEW  [NhaHangView] AS 
				SELECT TenHangBan FROM [tblDMHangBan] a JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma
				WHERE Ma = '2014201'
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