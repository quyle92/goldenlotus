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
		$sql = "SELECT *  FROM [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien]";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function layTatCaBaoCao(){
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblDMBaoCao] ";
		try {
			$rs = sqlsrv_query($this->conn, $sql); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layDanhSachUsers() {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [NH_STEAK_PIZZA].[dbo].[tblDSNguoiSD] a,  [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV 		";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function layBaoCao( $ma_bao_cao ){
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblDMBaoCao] WHERE [MaBaoCao] = '$ma_bao_cao' ";
		try {
			$rs = sqlsrv_query($this->conn, $sql);
			$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $r['TenBaoCao'];
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layTenUser($maNV) {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [NH_STEAK_PIZZA].[dbo].[tblDSNguoiSD] a,  [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV and MaNV ='$maNV'	";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function xoaUser( $maNV ){
		$sql = "DELETE FROM  [NH_STEAK_PIZZA].[dbo].[tblDSNguoiSD] where [MaNhanVien] = '$maNV'";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countOccupiedTables() : int {
		$sql = "SELECT * FROM  [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] where [ThoiGianDongPhieu] IS NULL";
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));

			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			return $count = sqlsrv_num_rows($rs);

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countTotalTables() : int {
		$sql = "SELECT * FROM  [NH_STEAK_PIZZA].[dbo].[tblDMBan]";
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));
			
			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			return $count = sqlsrv_num_rows($rs);

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}

	}

	public function getFoodSoldThisMonth ($thang_nay) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_nay' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldLastMonth ($thang_truoc) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_truoc' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if($rs != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldAnotherMonth ($thang_khac) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_khac' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldToday($hom_nay) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			
			if( $rs != false) 
				return $rs;
			else   die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldYesterday($hom_truoc) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false)  
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldAnotherDay($hom_khac) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_khac' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsToday($hom_nay){
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblOrderChiTiet] WHERE substring( Convert(varchar,ThoiGian,111),0,11 ) ='2020/08/26'";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsThisMonth($this_month){
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblOrderChiTiet] WHERE substring( Convert(varchar,ThoiGian,111),0,8 ) ='2020/08'";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function countTotalBillsEachDay($date){
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblOrderChiTiet] WHERE substring( Convert(varchar,ThoiGian,111),0,11 ) ='$date'";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return sqlsrv_num_rows( $rs );
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getDatesHasBillOfThisMonth( $this_month ) {
		$sql = "SELECT substring( Convert(varchar,ThoiGian,111),0,11 ) as NgayCoBill, count( * ) FROM [NH_STEAK_PIZZA].[dbo].[tblOrderChiTiet] WHERE substring( Convert(varchar,ThoiGian,111),0,8 ) ='2020/08' GROUP BY substring( Convert(varchar,ThoiGian,111),0,11 )";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsByDayOfMonth( $date ){
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblOrderChiTiet] WHERE substring( Convert(varchar,ThoiGian,111),0,11 ) ='$date'";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
}